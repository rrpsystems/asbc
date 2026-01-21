<?php

namespace App\Services;

use App\Models\Alert;
use App\Models\Customer;
use App\Models\RevenueSummary;
use App\Models\Cdr;
use Illuminate\Support\Facades\Log;

class AlertService
{
    /**
     * Verifica se cliente está próximo ou excedeu a franquia
     */
    public function checkFranchiseUsage($customerId, $mes, $ano)
    {
        $resumo = RevenueSummary::where('customer_id', $customerId)
            ->where('mes', $mes)
            ->where('ano', $ano)
            ->first();

        if (!$resumo) {
            return;
        }

        $percentualUsado = ($resumo->minutos_usados / $resumo->franquia_minutos) * 100;

        // Alerta crítico: Franquia excedida
        if ($percentualUsado >= 100) {
            $this->createAlert([
                'type' => Alert::TYPE_FRANCHISE_EXCEEDED,
                'severity' => Alert::SEVERITY_CRITICAL,
                'customer_id' => $customerId,
                'title' => 'Franquia Excedida',
                'message' => sprintf(
                    'Cliente %s excedeu a franquia de %s minutos. Uso atual: %s minutos (%.1f%%)',
                    $resumo->customer->razaosocial,
                    number_format($resumo->franquia_minutos, 0),
                    number_format($resumo->minutos_usados, 0),
                    $percentualUsado
                ),
                'metadata' => [
                    'franquia_minutos' => $resumo->franquia_minutos,
                    'minutos_usados' => $resumo->minutos_usados,
                    'minutos_excedentes' => $resumo->minutos_excedentes,
                    'percentual' => round($percentualUsado, 2),
                ],
            ]);
        }
        // Alerta de aviso: 80% da franquia
        elseif ($percentualUsado >= 80 && $percentualUsado < 100) {
            $this->createAlert([
                'type' => Alert::TYPE_FRANCHISE_WARNING,
                'severity' => Alert::SEVERITY_HIGH,
                'customer_id' => $customerId,
                'title' => 'Franquia Próxima do Limite',
                'message' => sprintf(
                    'Cliente %s está em %.1f%% da franquia (%s de %s minutos)',
                    $resumo->customer->razaosocial,
                    $percentualUsado,
                    number_format($resumo->minutos_usados, 0),
                    number_format($resumo->franquia_minutos, 0)
                ),
                'metadata' => [
                    'franquia_minutos' => $resumo->franquia_minutos,
                    'minutos_usados' => $resumo->minutos_usados,
                    'percentual' => round($percentualUsado, 2),
                ],
            ]);
        }
    }

    /**
     * Alerta de erro na tarifação
     */
    public function alertTarifacaoError($cdrId, $error)
    {
        $cdr = Cdr::find($cdrId);

        $this->createAlert([
            'type' => Alert::TYPE_TARIFACAO_ERROR,
            'severity' => Alert::SEVERITY_MEDIUM,
            'customer_id' => $cdr->customer_id ?? null,
            'carrier_id' => $cdr->carrier_id ?? null,
            'title' => 'Erro na Tarifação',
            'message' => sprintf(
                'CDR #%s não pôde ser tarifado. Erro: %s',
                $cdrId,
                $error
            ),
            'metadata' => [
                'cdr_id' => $cdrId,
                'error' => $error,
                'numero' => $cdr->numero ?? null,
                'tarifa' => $cdr->tarifa ?? null,
            ],
        ]);
    }

    /**
     * Alerta de pico de canais próximo ao limite
     */
    public function checkChannelPeak($carrierId = null)
    {
        if ($carrierId) {
            // Verifica carrier específico
            $carrier = \App\Models\Carrier::find($carrierId);

            $peakToday = Cdr::where('carrier_id', $carrierId)
                ->whereDate('calldate', today())
                ->whereNotNull('carrier_channels')
                ->where('carrier_channels', '!=', '')
                ->selectRaw('MAX(CAST(carrier_channels AS INTEGER)) as max_channels')
                ->value('max_channels');

            $percentual = ($peakToday / $carrier->canais) * 100;

            if ($percentual >= 90) {
                $this->createAlert([
                    'type' => Alert::TYPE_PEAK_CHANNELS,
                    'severity' => Alert::SEVERITY_HIGH,
                    'carrier_id' => $carrierId,
                    'title' => 'Pico de Canais Próximo ao Limite',
                    'message' => sprintf(
                        'Carrier %s atingiu %d de %d canais (%.1f%%)',
                        $carrier->operadora,
                        $peakToday,
                        $carrier->canais,
                        $percentual
                    ),
                    'metadata' => [
                        'peak_channels' => $peakToday,
                        'total_channels' => $carrier->canais,
                        'percentual' => round($percentual, 2),
                    ],
                ]);
            }
        }
    }

    /**
     * Detecção básica de fraude
     */
    public function detectFraud($customerId)
    {
        $today = today();

        // Critério 1: Mais de 100 chamadas em 1 hora
        $callsLastHour = Cdr::where('customer_id', $customerId)
            ->where('calldate', '>=', now()->subHour())
            ->count();

        if ($callsLastHour > 100) {
            $this->createAlert([
                'type' => Alert::TYPE_FRAUD_DETECTED,
                'severity' => Alert::SEVERITY_CRITICAL,
                'customer_id' => $customerId,
                'title' => 'Possível Fraude Detectada',
                'message' => sprintf(
                    'Cliente realizou %d chamadas na última hora (limite: 100)',
                    $callsLastHour
                ),
                'metadata' => [
                    'calls_last_hour' => $callsLastHour,
                    'detection_rule' => 'high_volume',
                ],
            ]);
        }

        // Critério 2: Chamadas para números premium
        $premiumCalls = Cdr::where('customer_id', $customerId)
            ->whereDate('calldate', $today)
            ->where('numero', 'LIKE', '0900%')
            ->count();

        if ($premiumCalls > 0) {
            $this->createAlert([
                'type' => Alert::TYPE_FRAUD_DETECTED,
                'severity' => Alert::SEVERITY_HIGH,
                'customer_id' => $customerId,
                'title' => 'Chamadas para Números Premium',
                'message' => sprintf(
                    'Detectadas %d chamadas para números 0900',
                    $premiumCalls
                ),
                'metadata' => [
                    'premium_calls' => $premiumCalls,
                    'detection_rule' => 'premium_numbers',
                ],
            ]);
        }
    }

    /**
     * Cria um alerta (evita duplicatas)
     */
    protected function createAlert(array $data)
    {
        // Verifica se já existe alerta similar não resolvido nas últimas 24h
        $exists = Alert::where('type', $data['type'])
            ->where('customer_id', $data['customer_id'] ?? null)
            ->where('carrier_id', $data['carrier_id'] ?? null)
            ->whereNull('resolved_at')
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if ($exists) {
            return; // Não cria alerta duplicado
        }

        Alert::create($data);

        // Log do alerta
        Log::warning('Alert created', $data);
    }

    /**
     * Retorna alertas não lidos
     */
    public function getUnreadAlerts()
    {
        return Alert::unread()
            ->unresolved()
            ->with(['customer', 'carrier'])
            ->orderBy('severity', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Conta alertas não lidos por severidade
     */
    public function countUnreadBySeverity()
    {
        return [
            'critical' => Alert::unread()->unresolved()->bySeverity(Alert::SEVERITY_CRITICAL)->count(),
            'high' => Alert::unread()->unresolved()->bySeverity(Alert::SEVERITY_HIGH)->count(),
            'medium' => Alert::unread()->unresolved()->bySeverity(Alert::SEVERITY_MEDIUM)->count(),
            'low' => Alert::unread()->unresolved()->bySeverity(Alert::SEVERITY_LOW)->count(),
        ];
    }
}
