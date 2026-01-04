<?php

namespace App\Services;

use App\Exceptions\Tariff\InvalidCdrDataException;
use App\Exceptions\Tariff\RateNotFoundException;
use App\Models\Cdr;
use App\Models\Rate;
use Illuminate\Support\Facades\Log;

class CallTariffService
{
    public function __construct(
        private readonly RateCacheService $rateCache,
        private readonly PriceCalculationService $priceCalculation
    ) {}

    /**
     * Calcula tarifa para um CDR
     */
    public function calcularTarifa(Cdr $cdr): array
    {
        $startTime = microtime(true);

        $this->validateCdr($cdr);

        // Busca rate com cache
        $rate = $this->rateCache->findRate(
            $cdr->carrier_id,
            $cdr->tarifa,
            $cdr->numero
        );

        if (!$rate) {
            throw new RateNotFoundException(
                "Tarifa não encontrada para carrier_id={$cdr->carrier_id}, " .
                "tarifa={$cdr->tarifa}, numero_prefix=" . substr($cdr->numero, 0, 5)
            );
        }

        // Calcula valores BASE (sem markup)
        $tempoCobrado = $this->calcularTempoCobrado($cdr->billsec, $rate);
        $valorCompra = $this->calcularValor($tempoCobrado, $rate->compra, $rate->vconexao);
        $valorVenda = $this->calcularValor($tempoCobrado, $rate->venda, $rate->vconexao);

        // Calcula valores FINAIS (com markup se tiver revenda)
        $valorVendaFinal = null;
        $valorMarkup = null;

        if ($cdr->customer && $cdr->customer->hasReseller()) {
            $valorVendaFinal = $this->priceCalculation->calculatePrice(
                $valorVenda,
                $cdr->customer,
                'chamadas'
            );
            $valorMarkup = $valorVendaFinal - $valorVenda;
        }

        $duration = (microtime(true) - $startTime) * 1000;

        Log::info('Tariff calculated', [
            'cdr_id' => $cdr->id,
            'carrier_id' => $cdr->carrier_id,
            'tarifa' => $cdr->tarifa,
            'billsec' => $cdr->billsec,
            'tempo_cobrado' => $tempoCobrado,
            'valor_compra' => $valorCompra,
            'valor_venda' => $valorVenda,
            'valor_venda_final' => $valorVendaFinal,
            'valor_markup' => $valorMarkup,
            'has_reseller' => !is_null($valorVendaFinal),
            'rate_id' => $rate->id,
            'duration_ms' => round($duration, 2)
        ]);

        return [
            'compra' => $valorCompra,
            'venda' => $valorVenda,  // Mantém valor BASE
            'valor_venda_final' => $valorVendaFinal,  // NULL se não tiver revenda
            'valor_markup' => $valorMarkup,  // NULL se não tiver revenda
            'tempo_cobrado' => $tempoCobrado,
            'rate_id' => $rate->id,
        ];
    }

    /**
     * Calcula tarifas em lote com pré-carga de cache
     */
    public function calcularTarifasEmLote(iterable $cdrs): array
    {
        $startTime = microtime(true);

        // Pré-carrega todas as rates necessárias
        $rates = $this->rateCache->preloadRates($cdrs);

        $resultados = [];
        $erros = [];

        foreach ($cdrs as $cdr) {
            try {
                $this->validateCdr($cdr);

                $cacheKey = $this->getCacheKeyForCdr($cdr);
                $rate = $rates[$cacheKey] ?? null;

                if (!$rate) {
                    $erros[] = [
                        'cdr_id' => $cdr->id,
                        'erro' => 'Rate não encontrada'
                    ];
                    continue;
                }

                $tempoCobrado = $this->calcularTempoCobrado($cdr->billsec, $rate);
                $valorCompra = $this->calcularValor($tempoCobrado, $rate->compra, $rate->vconexao);
                $valorVenda = $this->calcularValor($tempoCobrado, $rate->venda, $rate->vconexao);

                // Calcula valores FINAIS (com markup se tiver revenda)
                $valorVendaFinal = null;
                $valorMarkup = null;

                if ($cdr->customer && $cdr->customer->hasReseller()) {
                    $valorVendaFinal = $this->priceCalculation->calculatePrice(
                        $valorVenda,
                        $cdr->customer,
                        'chamadas'
                    );
                    $valorMarkup = $valorVendaFinal - $valorVenda;
                }

                $resultados[$cdr->id] = [
                    'compra' => $valorCompra,
                    'venda' => $valorVenda,  // Valor BASE
                    'valor_venda_final' => $valorVendaFinal,
                    'valor_markup' => $valorMarkup,
                    'tempo_cobrado' => $tempoCobrado,
                    'rate_id' => $rate->id,
                ];

            } catch (\Exception $e) {
                $erros[] = [
                    'cdr_id' => $cdr->id,
                    'erro' => $e->getMessage()
                ];
            }
        }

        $duration = (microtime(true) - $startTime) * 1000;
        $totalCdrs = is_countable($cdrs) ? count($cdrs) : iterator_count($cdrs);

        Log::info('Batch tariff calculation completed', [
            'total_cdrs' => $totalCdrs,
            'sucessos' => count($resultados),
            'erros' => count($erros),
            'duration_ms' => round($duration, 2),
            'avg_per_cdr_ms' => $totalCdrs > 0 ? round($duration / $totalCdrs, 2) : 0
        ]);

        return [
            'resultados' => $resultados,
            'erros' => $erros,
        ];
    }

    /**
     * Calcula custo total de CDRs em lote com cache de tarifas
     * @deprecated Use calcularTarifasEmLote() para melhor performance
     */
    public function calcularCustoTotalEmLote($cdrs)
    {
        $rateCache = [];
        $custoTotal = 0;

        foreach ($cdrs as $cdr) {
            // Cria chave única para cache baseada em carrier, tarifa e número
            $cacheKey = $cdr->carrier_id . '_' . $cdr->tarifa . '_' . $cdr->numero;

            // Verifica se já buscou a tarifa para esse número
            if (!isset($rateCache[$cacheKey])) {
                try {
                    $rate = Rate::where(function ($query) use ($cdr) {
                        $query->whereRaw('? LIKE prefixo || \'%\'', [$cdr->numero])
                            ->orWhereNull('prefixo');
                    })
                        ->where('carrier_id', $cdr->carrier_id)
                        ->where('tarifa', $cdr->tarifa)
                        ->where('ativo', true)
                        ->orderByRaw('LENGTH(prefixo) DESC NULLS LAST')
                        ->first();

                    $rateCache[$cacheKey] = $rate;
                } catch (\Exception $e) {
                    $rateCache[$cacheKey] = null;
                }
            }

            $rate = $rateCache[$cacheKey];

            if (!$rate) {
                continue; // Pula se não encontrou tarifa
            }

            // Calcula o tempo cobrado
            $tempoCobrado = $this->calcularTempoCobrado($cdr->billsec, $rate);

            // Calcula o valor de compra
            $valorCompra = $this->calcularValor($tempoCobrado, $rate->compra, $rate->vconexao);
            $custoTotal += $valorCompra;
        }

        return $custoTotal;
    }

    /**
     * Valida dados do CDR
     */
    private function validateCdr(Cdr $cdr): void
    {
        if (empty($cdr->numero)) {
            throw new InvalidCdrDataException("CDR {$cdr->id}: número vazio");
        }

        if ($cdr->billsec < 0) {
            throw new InvalidCdrDataException("CDR {$cdr->id}: billsec negativo ({$cdr->billsec})");
        }

        if (empty($cdr->carrier_id)) {
            throw new InvalidCdrDataException("CDR {$cdr->id}: carrier_id vazio");
        }

        if (empty($cdr->tarifa)) {
            throw new InvalidCdrDataException("CDR {$cdr->id}: tarifa vazia");
        }

        // Não valida o tipo de tarifa - aceita qualquer valor configurado nas rates
        // A validação real ocorre ao buscar a rate correspondente
    }

    /**
     * Calcula tempo cobrado com base nas regras de tarifação
     */
    protected function calcularTempoCobrado($tempoFalado, $rate)
    {
        // Ajusta se o valor da tarifa for zero retorna 0
        if ($rate->venda == 0) {
            return 0;
        }

        // Ajusta o tempo inicial se for menor que o falado
        if ($tempoFalado <= $rate->tempoinicial) {
            return 0;
        }

        // Ajusta para o tempo mínimo
        if ($tempoFalado < $rate->tempominimo) {
            return $rate->tempominimo;
        }

        // Calcula o tempo com base no incremento
        $tempoExtra = $tempoFalado - $rate->tempominimo;
        $incrementos = ceil($tempoExtra / $rate->incremento);

        return $rate->tempominimo + ($incrementos * $rate->incremento);
    }

    /**
     * Calcula valor monetário
     */
    protected function calcularValor($tempoCobrado, $valorTarifa, $valorConexao)
    {
        // O valor total inclui a conexão e o tempo tarifado
        return round(($tempoCobrado * ($valorTarifa / 60)) + $valorConexao, 4);
    }

    /**
     * Gera chave de cache para um CDR
     */
    private function getCacheKeyForCdr(Cdr $cdr): string
    {
        return sprintf('rate:%d:%s:%s',
            $cdr->carrier_id,
            $cdr->tarifa,
            md5($cdr->numero)
        );
    }
}
