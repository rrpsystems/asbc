<?php

namespace App\Livewire\Dashboard;

use App\Models\Cdr;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Index extends Component
{
    public $data;

    public $data1;

    public $data2;

    public $custoTotal;

    public $recentCalls;

    public $topDestinos;

    public $callsByType;

    public $maxChannelsInfo; // Pico de canais com hora

    public $callsPerHour; // Distribuição de chamadas por hora com pico

    // Métricas de hoje
    public $todayCost;
    public $todayCalls;
    public $todayDuration;

    // Filtro de período: 'hoje', 'semana', 'mes'
    public $periodoFiltro = 'mes';

    /**
     * Altera o período do filtro
     */
    public function setPeriodo($periodo)
    {
        $this->periodoFiltro = $periodo;
    }

    /**
     * Retorna as datas de início e fim baseado no filtro
     */
    protected function getPeriodoDatas()
    {
        return match($this->periodoFiltro) {
            'hoje' => [
                'inicio' => now()->startOfDay()->format('Y-m-d H:i:s'),
                'fim' => now()->format('Y-m-d H:i:s'),
                'label' => 'Hoje',
            ],
            'semana' => [
                'inicio' => now()->subDays(6)->startOfDay()->format('Y-m-d H:i:s'),
                'fim' => now()->format('Y-m-d H:i:s'),
                'label' => 'Últimos 7 Dias',
            ],
            'mes' => [
                'inicio' => now()->startOfMonth()->format('Y-m-d H:i:s'),
                'fim' => now()->format('Y-m-d H:i:s'),
                'label' => 'Este Mês',
            ],
        };
    }

    /**
     * Limpa o cache e força atualização
     */
    public function refresh()
    {
        $month = now()->format('Y-m');

        // Limpa todos os caches do dashboard mensal
        Cache::forget("dashboard:max_customer_channels:{$month}");
        Cache::forget("dashboard:max_calls:{$month}");
        Cache::forget("dashboard:max_channels:{$month}");
        Cache::forget("dashboard:total_cost:{$month}");
        Cache::forget("dashboard:top_destinos:{$month}:10");
        Cache::forget("dashboard:calls_by_type:{$month}");

        // Força limpeza completa do cache de tipos
        Cache::flush();

        // Limpa caches do dia (Resumo de Hoje)
        $today = now()->format('Y-m-d');
        Cache::forget("dashboard:recent_calls:all:10");
        Cache::forget("dashboard:today_cost:{$today}");
        Cache::forget("dashboard:today_calls:{$today}");
        Cache::forget("dashboard:today_duration:{$today}");
        Cache::forget("dashboard:calls_per_hour:{$month}");

        // Força re-renderização
        $this->render();
    }

    protected function maxCustomerChannels($startDate, $endDate)
    {
        $month = now()->format('Y-m');
        $cacheKey = "dashboard:max_customer_channels:{$this->periodoFiltro}:{$month}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($startDate, $endDate) {
            return Cdr::with('customer')->selectRaw('customer_id, MAX(customer_channels) as max_customer_channels')
                ->whereBetween('calldate', [$startDate, $endDate])
                ->groupBy('customer_id')
                ->orderBy('max_customer_channels', 'desc')
                ->get();
        });
    }

    protected function maxCalls($startDate, $endDate)
    {
        $month = now()->format('Y-m');
        $cacheKey = "dashboard:max_calls:{$this->periodoFiltro}:{$month}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($startDate, $endDate) {
            return Cdr::with('customer')->selectRaw('customer_id, COUNT(customer_id) as max_customer_calls, SUM(billsec) as total_billsec')
                ->whereBetween('calldate', [$startDate, $endDate])
                ->groupBy('customer_id')
                ->orderBy('max_customer_calls', 'desc')
                ->get();
        });
    }

    protected function maxChannels($startDate, $endDate)
    {
        $month = now()->format('Y-m');
        $cacheKey = "dashboard:max_channels:{$this->periodoFiltro}:{$month}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($startDate, $endDate) {
            return Cdr::selectRaw('
                EXTRACT(HOUR FROM calldate)::integer as hour_of_day,
                MAX(carrier_channels) as max_carrier_channels,
                MAX(customer_channels) as max_customer_channels,
                COUNT(*) as total_calls
            ')
                ->whereBetween('calldate', [$startDate, $endDate])
                ->groupBy('hour_of_day')
                ->orderBy('hour_of_day')
                ->get();
        });
    }

    protected function calculateTotalCost($startDate, $endDate)
    {
        $month = now()->format('Y-m');
        $cacheKey = "dashboard:total_cost:{$this->periodoFiltro}:{$month}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($startDate, $endDate) {
            // Usa o valor já calculado e armazenado no banco
            // Muito mais eficiente do que recalcular todas as tarifas
            return Cdr::whereBetween('calldate', [$startDate, $endDate])
                ->where('disposition', 'ANSWERED')
                ->sum('valor_compra');
        });
    }

    protected function getRecentCalls($limit = 10)
    {
        $cacheKey = "dashboard:recent_calls:all:{$limit}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($limit) {
            return Cdr::with(['customer', 'carrier'])
                ->orderBy('calldate', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    protected function getTopDestinos($startDate, $endDate, $limit = 10)
    {
        $month = now()->format('Y-m');
        $cacheKey = "dashboard:top_destinos:{$this->periodoFiltro}:{$month}:{$limit}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($startDate, $endDate, $limit) {
            return Cdr::selectRaw('numero, COUNT(*) as total_calls, SUM(billsec) as total_duration')
                ->whereBetween('calldate', [$startDate, $endDate])
                ->where('disposition', 'ANSWERED')
                ->groupBy('numero')
                ->orderBy('total_calls', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    protected function getCallsByType($startDate, $endDate)
    {
        $month = now()->format('Y-m');
        $cacheKey = "dashboard:calls_by_type:{$this->periodoFiltro}:{$month}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($startDate, $endDate) {
            // Usa o campo 'tarifa' que já vem da tabela de rates
            // Isso inclui: Fixo, Movel, Internacional, Entrada, e outros tipos customizados
            $results = Cdr::selectRaw('
                COALESCE(tarifa, \'Outros\') as tipo,
                COUNT(*) as total
            ')
                ->whereBetween('calldate', [$startDate, $endDate])
                ->where('disposition', 'ANSWERED')
                ->groupBy('tarifa')
                ->orderByRaw('COUNT(*) DESC')
                ->get();

            return $results;
        });
    }

    // Métricas de Hoje
    protected function getTodayCost($date)
    {
        $cacheKey = "dashboard:today_cost:{$date}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($date) {
            return Cdr::whereDate('calldate', $date)
                ->where('calldate', '<=', now())
                ->where('disposition', 'ANSWERED')
                ->sum('valor_compra');
        });
    }

    protected function getTodayCalls($date)
    {
        $cacheKey = "dashboard:today_calls:{$date}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($date) {
            return Cdr::whereDate('calldate', $date)
                ->where('calldate', '<=', now())
                ->where('disposition', 'ANSWERED')
                ->count();
        });
    }

    protected function getTodayDuration($date)
    {
        $cacheKey = "dashboard:today_duration:{$date}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($date) {
            return Cdr::whereDate('calldate', $date)
                ->where('calldate', '<=', now())
                ->where('disposition', 'ANSWERED')
                ->sum('billsec');
        });
    }

    /**
     * Retorna distribuição de chamadas por hora do dia
     * com identificação do pico de chamadas
     */
    protected function getCallsPerHour($startDate, $endDate)
    {
        $month = now()->format('Y-m');
        $cacheKey = "dashboard:calls_per_hour:{$this->periodoFiltro}:{$month}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($startDate, $endDate) {
            $hourlyData = Cdr::selectRaw('
                EXTRACT(HOUR FROM calldate)::integer as hour,
                COUNT(*) as total_calls,
                COUNT(CASE WHEN disposition = \'ANSWERED\' THEN 1 END) as answered_calls,
                COUNT(CASE WHEN disposition != \'ANSWERED\' THEN 1 END) as failed_calls,
                SUM(billsec) as total_duration,
                AVG(billsec) as avg_duration
            ')
                ->whereBetween('calldate', [$startDate, $endDate])
                ->groupBy('hour')
                ->orderBy('hour')
                ->get();

            // Encontra o pico
            $peakHour = $hourlyData->sortByDesc('total_calls')->first();

            return [
                'hourly' => $hourlyData,
                'peak' => [
                    'hour' => $peakHour ? sprintf('%02d:00', $peakHour->hour) : '--:--',
                    'hour_range' => $peakHour ? sprintf('%02d:00 - %02d:59', $peakHour->hour, $peakHour->hour) : '--',
                    'calls' => $peakHour->total_calls ?? 0,
                    'answered' => $peakHour->answered_calls ?? 0,
                    'failed' => $peakHour->failed_calls ?? 0,
                ],
            ];
        });
    }

    public function render()
    {
        // Define período baseado no filtro
        $periodo = $this->getPeriodoDatas();
        $startDate = $periodo['inicio'];
        $endDate = $periodo['fim'];
        $periodoLabel = $periodo['label'];
        $today = now()->format('Y-m-d');

        // Métricas do período selecionado
        $this->data = $this->maxChannels($startDate, $endDate);
        $this->data1 = $this->maxCustomerChannels($startDate, $endDate);
        $this->data2 = $this->maxCalls($startDate, $endDate);
        $this->custoTotal = $this->calculateTotalCost($startDate, $endDate);
        $this->topDestinos = $this->getTopDestinos($startDate, $endDate);
        $this->callsByType = $this->getCallsByType($startDate, $endDate);

        // Últimas chamadas (10 mais recentes do banco, independente de data)
        $this->recentCalls = $this->getRecentCalls();

        // Métricas de hoje (para seção "Resumo de Hoje")
        $this->todayCost = $this->getTodayCost($today);
        $this->todayCalls = $this->getTodayCalls($today);
        $this->todayDuration = $this->getTodayDuration($today);

        // Distribuição de chamadas por hora com pico
        $this->callsPerHour = $this->getCallsPerHour($startDate, $endDate);

        // Calcula pico de canais do período (agora por faixa horária)
        $maxChannels = $this->data->max('max_carrier_channels');
        $maxHour = $this->data->where('max_carrier_channels', $maxChannels)->first();

        $this->maxChannelsInfo = [
            'max' => $maxChannels ?? 0,
            'hour' => $maxHour ? sprintf('%02dh', $maxHour->hour_of_day) : '--h'
        ];

        return view('livewire.dashboard.index', [
            'periodoLabel' => $periodoLabel,
        ]);
    }
}
