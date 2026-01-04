<?php

namespace App\Services;

use App\Models\Carrier;
use App\Models\Cdr;
use App\Models\Did;

class CarrierCostAllocationService
{
    /**
     * Cache de carriers para evitar queries repetidas
     */
    private array $carrierCache = [];

    /**
     * Limpa o cache de carriers
     */
    public function clearCache(): void
    {
        $this->carrierCache = [];
    }

    /**
     * Busca carrier do cache ou carrega do banco
     */
    private function getCarrier($carrierId): ?Carrier
    {
        if (!isset($this->carrierCache[$carrierId])) {
            $this->carrierCache[$carrierId] = Carrier::find($carrierId);
        }

        return $this->carrierCache[$carrierId];
    }

    /**
     * Calcula custos reais de MÚLTIPLAS operadoras em batch (OTIMIZADO)
     * Reduz N queries para 2-3 queries totais
     *
     * @param array $carrierIds Array de IDs das operadoras
     * @param int $mes Mês (1-12)
     * @param int $ano Ano
     * @return array Array associativo [carrier_id => dados de custo]
     */
    public function calcularCustoRealMultiplos(array $carrierIds, $mes, $ano): array
    {
        if (empty($carrierIds)) {
            return [];
        }

        // 1. Carrega todos carriers de uma vez
        $carriers = Carrier::whereIn('id', $carrierIds)->get()->keyBy('id');

        // Preenche cache
        foreach ($carriers as $id => $carrier) {
            $this->carrierCache[$id] = $carrier;
        }

        // 2. Busca estatísticas de TODAS operadoras em 1 query
        // Apenas CDRs já processados nas faturas dos clientes
        $estatisticas = Cdr::whereIn('carrier_id', $carrierIds)
            ->whereMonth('calldate', $mes)
            ->whereYear('calldate', $ano)
            ->where('status', 'Tarifada')
            ->whereNotNull('revenue_summary_id')
            ->selectRaw('
                carrier_id,
                tarifa,
                SUM(tempo_cobrado) as total_minutos,
                SUM(valor_compra) as custo
            ')
            ->groupBy('carrier_id', 'tarifa')
            ->get()
            ->groupBy('carrier_id');

        // 3. Busca DIDs ativos de TODAS operadoras em 1 query
        $didsAtivos = Did::whereIn('carrier_id', $carrierIds)
            ->where('ativo', true)
            ->selectRaw('carrier_id, COUNT(*) as total')
            ->groupBy('carrier_id')
            ->get()
            ->pluck('total', 'carrier_id');

        // 4. Processa cada operadora em memória
        $resultados = [];

        foreach ($carrierIds as $carrierId) {
            $carrier = $carriers->get($carrierId);

            if (!$carrier) {
                $resultados[$carrierId] = [
                    'custo_variavel' => 0,
                    'custo_fixo' => 0,
                    'custo_total' => 0,
                ];
                continue;
            }

            $stats = $estatisticas->get($carrierId, collect());
            $minutosPorTipo = $stats->keyBy('tarifa');

            // Calcula custos variáveis
            $custoFixo = $minutosPorTipo->get('Fixo')->custo ?? 0;
            $custoMovel = $minutosPorTipo->get('Movel')->custo ?? 0;
            $custoInternacional = $minutosPorTipo->get('Internacional')->custo ?? 0;

            $custoVariavel = 0;

            if ($carrier->franquia_compartilhada) {
                $custoFixoMovel = $custoFixo + $custoMovel;
                $franquiaDisponivel = $carrier->franquia_valor_nacional;
                $custoVariavel = max(0, $custoFixoMovel - $franquiaDisponivel);
            } else {
                $excedenteFixo = max(0, $custoFixo - $carrier->franquia_valor_fixo);
                $excedenteMovel = max(0, $custoMovel - $carrier->franquia_valor_movel);
                $custoVariavel = $excedenteFixo + $excedenteMovel;
            }

            $custoVariavel += $custoInternacional;

            // Detalhes
            $qtdDidsAtivos = $didsAtivos->get($carrierId, 0);
            $custoPorDid = $qtdDidsAtivos > 0 ? $carrier->valor_plano_mensal / $qtdDidsAtivos : 0;

            $resultados[$carrierId] = [
                'custo_variavel' => $custoVariavel,
                'custo_fixo' => $carrier->valor_plano_mensal,
                'custo_total' => $custoVariavel + $carrier->valor_plano_mensal,
                'detalhes' => [
                    'plano_mensal' => $carrier->valor_plano_mensal,
                    'dids_ativos' => $qtdDidsAtivos,
                    'dids_inclusos' => $carrier->dids_inclusos,
                    'custo_por_did' => $custoPorDid,
                    'franquia_valor_fixo' => $carrier->franquia_valor_fixo,
                    'franquia_valor_movel' => $carrier->franquia_valor_movel,
                    'franquia_valor_nacional' => $carrier->franquia_valor_nacional,
                    'franquia_compartilhada' => $carrier->franquia_compartilhada,
                    'minutos_fixo' => $minutosPorTipo->get('Fixo')->total_minutos ?? 0,
                    'minutos_movel' => $minutosPorTipo->get('Movel')->total_minutos ?? 0,
                    'minutos_internacional' => $minutosPorTipo->get('Internacional')->total_minutos ?? 0,
                    'custo_fixo' => $custoFixo,
                    'custo_movel' => $custoMovel,
                    'custo_internacional' => $custoInternacional,
                ],
            ];
        }

        return $resultados;
    }

    /**
     * Calcula o custo total real de uma operadora incluindo custos fixos
     */
    public function calcularCustoReal($carrierId, $mes, $ano)
    {
        $carrier = $this->getCarrier($carrierId);

        if (!$carrier) {
            return [
                'custo_variavel' => 0,
                'custo_fixo' => 0,
                'custo_total' => 0,
            ];
        }

        // 1. Custo variável (minutos acima da franquia)
        $custoVariavel = $this->calcularCustoVariavel($carrierId, $mes, $ano, $carrier);

        // 2. Custo fixo do plano
        $custoFixo = $carrier->valor_plano_mensal;

        return [
            'custo_variavel' => $custoVariavel,
            'custo_fixo' => $custoFixo,
            'custo_total' => $custoVariavel + $custoFixo,
            'detalhes' => $this->detalharCustos($carrierId, $mes, $ano, $carrier),
        ];
    }

    /**
     * Calcula custos variáveis E detalhes em uma única query otimizada
     * Reduz 5 queries separadas para 1 query com GROUP BY
     */
    private function calcularCustosOtimizado($carrierId, $mes, $ano, $carrier)
    {
        // 1 query consolidada que retorna tudo agrupado por tipo
        // Apenas CDRs já processados nas faturas dos clientes
        $minutosPorTipo = Cdr::where('carrier_id', $carrierId)
            ->whereMonth('calldate', $mes)
            ->whereYear('calldate', $ano)
            ->where('status', 'Tarifada')
            ->whereNotNull('revenue_summary_id')
            ->selectRaw('tarifa, SUM(tempo_cobrado) as total_minutos, SUM(valor_compra) as custo')
            ->groupBy('tarifa')
            ->get()
            ->keyBy('tarifa');

        // Extrair custos por tipo
        $custoFixo = $minutosPorTipo->get('Fixo')->custo ?? 0;
        $custoMovel = $minutosPorTipo->get('Movel')->custo ?? 0;
        $custoInternacional = $minutosPorTipo->get('Internacional')->custo ?? 0;
        $custoTotal = $custoFixo + $custoMovel + $custoInternacional;

        // Calcular custo variável baseado na franquia
        $custoVariavel = 0;

        if ($carrier->franquia_compartilhada) {
            // Franquia compartilhada: considera fixo + móvel juntos
            $custoFixoMovel = $custoFixo + $custoMovel;
            $franquiaDisponivel = $carrier->franquia_valor_nacional;
            $custoVariavel = max(0, $custoFixoMovel - $franquiaDisponivel);
        } else {
            // Franquias separadas
            $excedenteFixo = max(0, $custoFixo - $carrier->franquia_valor_fixo);
            $excedenteMovel = max(0, $custoMovel - $carrier->franquia_valor_movel);
            $custoVariavel = $excedenteFixo + $excedenteMovel;
        }

        // Internacional sempre é cobrado (sem franquia)
        $custoVariavel += $custoInternacional;

        return [
            'custo_variavel' => $custoVariavel,
            'minutos_por_tipo' => $minutosPorTipo,
            'custo_total_chamadas' => $custoTotal,
        ];
    }

    /**
     * Calcula apenas os custos variáveis (acima da franquia em valor R$)
     */
    private function calcularCustoVariavel($carrierId, $mes, $ano, $carrier)
    {
        $resultado = $this->calcularCustosOtimizado($carrierId, $mes, $ano, $carrier);
        return $resultado['custo_variavel'];
    }

    /**
     * Detalha os custos por categoria
     */
    private function detalharCustos($carrierId, $mes, $ano, $carrier)
    {
        $resultado = $this->calcularCustosOtimizado($carrierId, $mes, $ano, $carrier);
        $minutosPorTipo = $resultado['minutos_por_tipo'];

        // Quantidade de DIDs ativos da operadora
        $didsAtivos = Did::where('carrier_id', $carrierId)
            ->where('ativo', true)
            ->count();

        $custoPorDid = $didsAtivos > 0 ? $carrier->valor_plano_mensal / $didsAtivos : 0;

        return [
            'plano_mensal' => $carrier->valor_plano_mensal,
            'dids_ativos' => $didsAtivos,
            'dids_inclusos' => $carrier->dids_inclusos,
            'custo_por_did' => $custoPorDid,
            'franquia_valor_fixo' => $carrier->franquia_valor_fixo,
            'franquia_valor_movel' => $carrier->franquia_valor_movel,
            'franquia_valor_nacional' => $carrier->franquia_valor_nacional,
            'franquia_compartilhada' => $carrier->franquia_compartilhada,
            'minutos_fixo' => $minutosPorTipo->get('Fixo')->total_minutos ?? 0,
            'minutos_movel' => $minutosPorTipo->get('Movel')->total_minutos ?? 0,
            'minutos_internacional' => $minutosPorTipo->get('Internacional')->total_minutos ?? 0,
            'custo_fixo' => $minutosPorTipo->get('Fixo')->custo ?? 0,
            'custo_movel' => $minutosPorTipo->get('Movel')->custo ?? 0,
            'custo_internacional' => $minutosPorTipo->get('Internacional')->custo ?? 0,
        ];
    }

    /**
     * Rateia o custo entre clientes baseado nos DIDs que cada um possui
     *
     * Lógica:
     * - Custo Fixo = (Valor Plano / DIDs Ativos) × Quantidade de DIDs do Cliente
     * - Custo Variável = Soma dos custos variáveis de todos os DIDs do cliente
     * - Não usa franquia por cliente, pois a franquia é da operadora (total)
     */
    public function ratearCustoFixoPorCliente($carrierId, $mes, $ano)
    {
        $carrier = Carrier::find($carrierId);

        // Pega todos os DIDs ativos da operadora
        $didsAtivos = Did::where('carrier_id', $carrierId)
            ->where('ativo', true)
            ->get();

        if ($didsAtivos->isEmpty()) {
            return [];
        }

        // Calcula custo por DID para ratear
        $custosDidDetalhados = $this->ratearCustoPorDid($carrierId, $mes, $ano);

        // Agrupa por cliente
        $rateioClientes = collect($custosDidDetalhados)
            ->groupBy('customer_id')
            ->map(function ($didsDoCliente, $customerId) use ($carrier, $didsAtivos) {
                $quantidadeDids = $didsDoCliente->count();

                // Custo fixo baseado nos DIDs que o cliente possui
                // Ex: (R$ 2.000 / 109 DIDs ativos) × 10 DIDs do cliente = R$ 183,49
                $didsDoPlano = $carrier->dids_inclusos > 0 ? $carrier->dids_inclusos : $didsAtivos->count();
                $custoPorDid = $carrier->valor_plano_mensal / $didsDoPlano;
                $custoFixoCliente = $custoPorDid * $quantidadeDids;

                // Custo variável = soma dos custos variáveis de todos os DIDs do cliente
                $custoVariavelCliente = $didsDoCliente->sum('custo_variavel');

                // Minutos totais do cliente
                $minutosCliente = $didsDoCliente->sum('minutos');

                return [
                    'customer_id' => $customerId,
                    'quantidade_dids' => $quantidadeDids,
                    'minutos' => $minutosCliente,
                    'custo_fixo_rateado' => $custoFixoCliente,
                    'custo_variavel' => $custoVariavelCliente,
                    'custo_total' => $custoFixoCliente + $custoVariavelCliente,
                ];
            })
            ->values();

        return $rateioClientes;
    }

    /**
     * Persiste resumo mensal de custos na tabela carrier_usages
     * Usado para marcar meses como "fechados" após faturamento
     *
     * @param int $mes Mês (1-12)
     * @param int $ano Ano (ex: 2025)
     * @param int|null $carrierId Operadora específica ou null para todas
     * @return int Número de registros criados/atualizados
     */
    public function persistirResumoMensal($mes, $ano, $carrierId = null)
    {
        // Valida parâmetros
        if ($mes < 1 || $mes > 12) {
            throw new \InvalidArgumentException("Mês inválido: {$mes}. Deve estar entre 1 e 12.");
        }

        if ($ano < 2000 || $ano > 2100) {
            throw new \InvalidArgumentException("Ano inválido: {$ano}.");
        }

        // Query base para CDRs
        // Apenas CDRs que já foram processados nas faturas dos clientes
        $query = Cdr::whereMonth('calldate', $mes)
            ->whereYear('calldate', $ano)
            ->where('status', 'Tarifada')
            ->whereNotNull('revenue_summary_id');

        if ($carrierId) {
            $query->where('carrier_id', $carrierId);
        }

        // Agrupa por operadora e tipo de serviço
        $resumos = $query->selectRaw('
                carrier_id,
                tarifa as tipo_servico,
                SUM(tempo_cobrado) as total_minutos,
                SUM(valor_compra) as total_custo
            ')
            ->groupBy('carrier_id', 'tarifa')
            ->get();

        $count = 0;

        foreach ($resumos as $resumo) {
            // Pega informações da operadora
            $carrier = Carrier::find($resumo->carrier_id);

            \App\Models\CarrierUsage::updateOrCreate(
                [
                    'carrier_id' => $resumo->carrier_id,
                    'tipo_servico' => $resumo->tipo_servico,
                    'mes' => $mes,
                    'ano' => $ano,
                ],
                [
                    'minutos_utilizados' => $resumo->total_minutos,
                    'custo_total' => $resumo->total_custo,
                    'franquia_minutos' => 0, // Campo mantido para compatibilidade
                    'valor_plano' => $carrier ? $carrier->valor_plano_mensal : 0,
                ]
            );

            $count++;
        }

        return $count;
    }

    /**
     * Rateia o custo fixo por DID
     *
     * Lógica:
     * - Custo Fixo por DID = Valor Plano Mensal ÷ Quantidade de DIDs ativos
     * - Custo Variável = Valor das chamadas deste DID (considerando franquia)
     * - Se houver franquia, deduz do custo variável
     */
    public function ratearCustoPorDid($carrierId, $mes, $ano)
    {
        $carrier = Carrier::find($carrierId);
        $didsAtivos = Did::with('customer:id,nomefantasia,razaosocial')
            ->where('carrier_id', $carrierId)
            ->where('ativo', true)
            ->get();

        if ($didsAtivos->isEmpty()) {
            return [];
        }

        // Custo fixo dividido pelos DIDs inclusos no plano (não pelos DIDs cadastrados)
        // Exemplo: R$ 2.000 / 200 DIDs do plano = R$ 10,00 por DID (custo contratado)
        $didsDoPlano = $carrier->dids_inclusos > 0 ? $carrier->dids_inclusos : $didsAtivos->count();
        $custoContratadoPorDid = $carrier->valor_plano_mensal / $didsDoPlano;

        // Custo real considerando apenas DIDs ativos (para análise de eficiência)
        // Exemplo: R$ 2.000 / 109 DIDs ativos = R$ 18,35 por DID (custo real)
        $custoRealPorDidAtivo = $carrier->valor_plano_mensal / $didsAtivos->count();

        // Custo dos DIDs ociosos rateado entre os ativos
        $didsOciosos = $didsDoPlano - $didsAtivos->count();
        $custoOciososPorDidAtivo = $didsOciosos > 0
            ? ($custoContratadoPorDid * $didsOciosos) / $didsAtivos->count()
            : 0;

        // Uso por DID - agrupamento otimizado
        // Calcula tudo em uma única query (antes eram 2 queries)
        // Apenas CDRs já processados nas faturas dos clientes
        $usoPorDid = Cdr::where('carrier_id', $carrierId)
            ->whereMonth('calldate', $mes)
            ->whereYear('calldate', $ano)
            ->where('status', 'Tarifada')
            ->whereNotNull('revenue_summary_id')
            ->selectRaw('did_id, SUM(tempo_cobrado) as total_minutos, SUM(valor_compra) as custo')
            ->groupBy('did_id')
            ->get()
            ->keyBy('did_id');

        // Calcula total de chamadas a partir dos dados já agrupados (sem query adicional)
        $custoTotalChamadas = $usoPorDid->sum('custo');

        $franquia = $carrier->franquia_compartilhada
            ? $carrier->franquia_valor_nacional
            : ($carrier->franquia_valor_fixo + $carrier->franquia_valor_movel);

        $excedenteTotal = max(0, $custoTotalChamadas - $franquia);

        // Uso por DID
        return $didsAtivos->map(function ($did) use ($custoContratadoPorDid, $custoRealPorDidAtivo, $custoOciososPorDidAtivo, $custoTotalChamadas, $excedenteTotal, $usoPorDid) {
            $stats = $usoPorDid->get($did->id);
            $minutosUsados = $stats ? $stats->total_minutos : 0;
            $custoChamadasDid = $stats ? $stats->custo : 0;

            // Calcular proporção do custo variável (excedente) para este DID
            $proporcao = $custoTotalChamadas > 0 ? ($custoChamadasDid / $custoTotalChamadas) : 0;
            $custoVariavelExcedente = $excedenteTotal * $proporcao;

            // Custo variável total = ociosos rateados + excedente de franquia
            $custoVariavelTotal = $custoOciososPorDidAtivo + $custoVariavelExcedente;

            return [
                'did_id' => $did->id,
                'numero' => $did->did,
                'customer_id' => $did->customer_id,
                'customer_nome' => $did->customer?->nomefantasia ?? $did->customer?->razaosocial ?? null,
                'minutos' => $minutosUsados,
                'custo_contratado' => $custoContratadoPorDid, // R$ 10,00 (2000/200)
                'custo_real_ativo' => $custoRealPorDidAtivo,  // R$ 18,35 (2000/109)
                'custo_ociosos' => $custoOciososPorDidAtivo,   // Parte dos 91 DIDs ociosos
                'custo_variavel_excedente' => $custoVariavelExcedente, // Excedente franquia
                'custo_variavel' => $custoVariavelTotal,       // Ociosos + Excedente
                'custo_total' => $custoContratadoPorDid + $custoVariavelTotal,
            ];
        });
    }
}
