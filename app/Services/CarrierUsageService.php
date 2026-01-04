<?php

namespace App\Services;

use App\Models\Cdr;
use App\Models\CarrierUsage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * @deprecated Este service está DEPRECADO e será removido em versão futura.
 *
 * PROBLEMAS CRÍTICOS:
 * 1. Método atualizarResumo() NUNCA foi chamado (código morto)
 * 2. Race conditions em atualizações incrementais
 * 3. Duplicação de funcionalidade com CarrierCostAllocationService
 * 4. Tabela carrier_usages usada apenas para campo 'fechado'
 *
 * SUBSTITUÍDO POR:
 * - CarrierCostAllocationService->persistirResumoMensal()
 * - Comandos migrados para usar o novo service
 *
 * @see \App\Services\CarrierCostAllocationService
 */
class CarrierUsageService
{
    /**
     * Atualiza ou cria o resumo de uso da operadora
     *
     * @deprecated NUNCA foi usado! Este método nunca foi chamado em nenhum lugar do código.
     * @see \App\Services\CarrierCostAllocationService::persistirResumoMensal()
     */
    public function atualizarResumo($cdr)
    {
        Log::warning('CarrierUsageService::atualizarResumo() DEPRECADO foi chamado - NÃO USE!', [
            'cdr_id' => $cdr->id ?? 'unknown',
            'carrier_id' => $cdr->carrier_id ?? 'unknown',
            'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3),
        ]);

        // NOTA: Este método NUNCA foi usado em produção
        // Mantido apenas para compatibilidade temporária

        // Encontra ou cria o resumo para a operadora no mês/ano do CDR
        $resumo = CarrierUsage::firstOrCreate(
            [
                'carrier_id' => $cdr->carrier_id,
                'mes' => Carbon::parse($cdr->calldate)->month,
                'ano' => Carbon::parse($cdr->calldate)->year,
            ],
            [
                'franquia_minutos' => 0,
                'minutos_utilizados' => 0,
                'valor_plano' => 0,
                'custo_total' => 0,
            ]
        );

        // Adiciona os minutos e custo da chamada
        // AVISO: Race condition - múltiplos processos podem corromper dados
        $resumo->minutos_utilizados += $cdr->tempo_cobrado;
        $resumo->custo_total += $cdr->valor_compra;
        $resumo->save();

        return $resumo;
    }

    /**
     * Recalcula todos os relatórios de um mês/ano específico
     *
     * @deprecated Use CarrierCostAllocationService::persistirResumoMensal()
     * @see \App\Services\CarrierCostAllocationService::persistirResumoMensal()
     */
    public function recalcularMes($mes, $ano, $carrierId = null)
    {
        Log::warning('CarrierUsageService::recalcularMes() DEPRECADO - Use CarrierCostAllocationService', [
            'mes' => $mes,
            'ano' => $ano,
            'carrier_id' => $carrierId,
            'trace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3),
        ]);

        // Redireciona para o novo service
        $service = new \App\Services\CarrierCostAllocationService();
        return $service->persistirResumoMensal($mes, $ano, $carrierId);
    }
}
