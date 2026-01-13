<?php

namespace App\Console\Commands;

use App\Models\Carrier;
use App\Models\Customer;
use App\Services\AlertService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckAlerts extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'alerts:check';

    /**
     * The console command description.
     */
    protected $description = 'Verifica condições para gerar alertas (fraude, pico de canais, etc)';

    protected $alertService;

    /**
     * Create a new command instance.
     */
    public function __construct(AlertService $alertService)
    {
        parent::__construct();
        $this->alertService = $alertService;
    }

    /**
     * Execute the console command.
     *
     * OTIMIZADO: Usa queries agregadas para identificar apenas clientes/carriers
     * com atividade suspeita, reduzindo drasticamente o número de queries.
     */
    public function handle()
    {
        $this->info('Iniciando verificação de alertas (otimizado)...');

        // 1. Verifica fraude para clientes ativos
        $this->info('Verificando fraudes...');
        $fraudChecked = $this->checkFrauds();
        $this->info("Fraudes verificadas: {$fraudChecked} cliente(s) com atividade suspeita");

        // 2. Verifica pico de canais para carriers ativos
        $this->info('Verificando pico de canais...');
        $channelChecked = $this->checkChannelPeaks();
        $this->info("Picos de canais verificados: {$channelChecked} operadora(s) com pico alto");

        $this->info('Verificação de alertas concluída!');

        return 0;
    }

    /**
     * Verifica fraudes usando queries agregadas (otimizado)
     *
     * ANTES: N queries (1 por cliente)
     * DEPOIS: 2 queries agregadas + N queries apenas para clientes suspeitos
     */
    protected function checkFrauds()
    {
        $checked = 0;

        // Query agregada 1: Clientes com > 100 chamadas na última hora
        $suspiciousHighVolume = \App\Models\Cdr::where('calldate', '>=', now()->subHour())
            ->selectRaw('customer_id, COUNT(*) as calls_count')
            ->groupBy('customer_id')
            ->havingRaw('COUNT(*) > 100')
            ->pluck('customer_id')
            ->toArray();

        // Query agregada 2: Clientes com chamadas premium hoje
        $suspiciousPremium = \App\Models\Cdr::whereDate('calldate', today())
            ->where('numero', 'LIKE', '0900%')
            ->distinct()
            ->pluck('customer_id')
            ->toArray();

        // Combina os dois grupos (sem duplicatas)
        $suspiciousCustomers = array_unique(array_merge($suspiciousHighVolume, $suspiciousPremium));

        // Verifica apenas clientes suspeitos (muito mais eficiente)
        foreach ($suspiciousCustomers as $customerId) {
            try {
                // Verifica se cliente está ativo
                $isActive = \App\Models\Customer::where('id', $customerId)
                    ->where('ativo', true)
                    ->exists();

                if ($isActive) {
                    $this->alertService->detectFraud($customerId);
                    $checked++;
                }
            } catch (\Exception $e) {
                Log::error('Erro ao verificar fraude', [
                    'customer_id' => $customerId,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $checked;
    }

    /**
     * Verifica picos de canais usando query agregada (otimizado)
     *
     * ANTES: N queries (1 por carrier)
     * DEPOIS: 2 queries (1 para carriers, 1 agregada para picos) + N queries apenas para carriers com pico alto
     */
    protected function checkChannelPeaks()
    {
        $checked = 0;

        // Query 1: Busca carriers ativos
        $carriers = \App\Models\Carrier::where('ativo', true)
            ->select('id', 'operadora', 'canais')
            ->get()
            ->keyBy('id');

        if ($carriers->isEmpty()) {
            return 0;
        }

        // Query 2: Busca picos de hoje para todos carriers em uma única query agregada
        $peaksToday = \App\Models\Cdr::whereDate('calldate', today())
            ->whereIn('carrier_id', $carriers->keys())
            ->whereNotNull('carrier_channels')
            ->where('carrier_channels', '!=', '')
            ->selectRaw('carrier_id, MAX(CAST(carrier_channels AS INTEGER)) as peak_channels')
            ->groupBy('carrier_id')
            ->get()
            ->keyBy('carrier_id');

        // Processa apenas carriers com pico >= 90%
        foreach ($carriers as $carrierId => $carrier) {
            try {
                $peakToday = $peaksToday->get($carrierId)?->peak_channels ?? 0;

                if ($carrier->canais > 0) {
                    $percentual = ($peakToday / $carrier->canais) * 100;

                    // Só chama o service se tiver pico >= 90%
                    if ($percentual >= 90) {
                        $this->alertService->checkChannelPeak($carrier->id);
                        $checked++;
                    }
                }
            } catch (\Exception $e) {
                Log::error('Erro ao verificar pico de canais', [
                    'carrier_id' => $carrier->id,
                    'error' => $e->getMessage()
                ]);
            }
        }

        return $checked;
    }
}
