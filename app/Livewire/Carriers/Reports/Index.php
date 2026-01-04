<?php

namespace App\Livewire\Carriers\Reports;

use App\Livewire\Traits\Table;
use App\Models\Carrier;
use App\Models\CarrierUsage;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Index extends Component
{
    use Table;

    public $mes;
    public $ano;
    public $carrier_id;
    public $tipo_servico;

    public function mount()
    {
        // Define o mês e ano atual como padrão
        $this->mes = now()->month;
        $this->ano = now()->year;
    }

    /**
     * Limpa cache automaticamente quando filtros mudam
     */
    public function updated($property)
    {
        // Quando qualquer filtro muda, limpa o cache
        if (in_array($property, ['mes', 'ano', 'carrier_id', 'tipo_servico'])) {
            $cacheKey = "carrier_reports_totals:{$this->mes}:{$this->ano}:{$this->carrier_id}:{$this->tipo_servico}";
            Cache::forget($cacheKey);
        }
    }

    /**
     * Limpa cache e força atualização
     */
    public function refresh()
    {
        // Limpar cache do período atual
        $cacheKey = "carrier_reports_totals:{$this->mes}:{$this->ano}:{$this->carrier_id}:{$this->tipo_servico}";
        Cache::forget($cacheKey);

        // Limpar cache do mês anterior também
        if ($this->mes !== null && $this->mes !== '' && $this->ano !== null && $this->ano !== '') {
            $mesAnterior = $this->mes - 1;
            $anoAnterior = $this->ano;
            if ($mesAnterior < 1) {
                $mesAnterior = 12;
                $anoAnterior = $this->ano - 1;
            }
            $cacheKeyAnterior = "carrier_reports_totals:{$mesAnterior}:{$anoAnterior}:{$this->carrier_id}:{$this->tipo_servico}";
            Cache::forget($cacheKeyAnterior);
        }

        // Limpar todo o cache de carrier_reports se necessário
        // Cache::flush(); // Use apenas se quiser limpar TUDO

        session()->flash('message', 'Cache atualizado com sucesso!');
    }

    /**
     * Limpa todos os filtros
     */
    public function clearFilters()
    {
        $this->mes = now()->month;
        $this->ano = now()->year;
        $this->carrier_id = null;
        $this->tipo_servico = null;
    }

    /**
     * Exporta relatório para Excel
     */
    public function exportExcel()
    {
        // TODO: Implementar exportação Excel
        session()->flash('message', 'Exportação Excel em desenvolvimento');
    }

    /**
     * Exporta relatório para PDF
     */
    public function exportPdf()
    {
        // TODO: Implementar exportação PDF
        session()->flash('message', 'Exportação PDF em desenvolvimento');
    }

    public function render()
    {
        // Busca diretamente da tabela CDR (igual ao relatório de faturas)
        $query = \App\Models\Cdr::with('carrier')
            ->where('tempo_cobrado', '>', 1) // Mesmo filtro do relatório de faturas
            ->selectRaw('
                carrier_id,
                tarifa as tipo_servico,
                EXTRACT(MONTH FROM calldate) as mes,
                EXTRACT(YEAR FROM calldate) as ano,
                SUM(tempo_cobrado) as minutos_utilizados,
                SUM(valor_compra) as custo_total
            ')
            ->groupBy('carrier_id', 'tarifa', 'mes', 'ano');

        // Filtros
        if ($this->mes !== null && $this->mes !== '') {
            $query->whereRaw('EXTRACT(MONTH FROM calldate) = ?', [$this->mes]);
        }
        if ($this->ano !== null && $this->ano !== '') {
            $query->whereRaw('EXTRACT(YEAR FROM calldate) = ?', [$this->ano]);
        }
        if ($this->carrier_id !== null && $this->carrier_id !== '') {
            $query->where('carrier_id', $this->carrier_id);
        }
        if ($this->tipo_servico !== null && $this->tipo_servico !== '') {
            $query->where('tarifa', $this->tipo_servico);
        }

        // Ordenação (apenas colunas do GROUP BY ou agregadas)
        $sortColumn = $this->sort ?? 'carrier_id';

        // Mapear colunas que podem ser ordenadas
        $allowedSorts = ['carrier_id', 'tipo_servico', 'mes', 'ano', 'minutos_utilizados', 'custo_total'];

        if (in_array($sortColumn, $allowedSorts)) {
            // Se for tipo_servico, ordenar pela coluna original 'tarifa'
            if ($sortColumn === 'tipo_servico') {
                $query->orderBy('tarifa', $this->direction ?? 'asc');
            } else {
                $query->orderBy($sortColumn, $this->direction ?? 'asc');
            }
        } else {
            // Default: ordenar por carrier_id
            $query->orderBy('carrier_id', 'asc');
        }

        $reports = $query->paginate($this->perPage);

        // Lista de operadoras para o filtro
        $carriers = Carrier::orderBy('operadora')->get();

        // Lista de tipos de serviço disponíveis
        $tiposServico = ['Fixo', 'Movel', 'Internacional', 'Entrada', 'Servico', 'Outros', 'Gratuito'];

        // Cálculo dos totais com cache (15 minutos) - direto da tabela CDR
        $cacheKey = "carrier_reports_totals:{$this->mes}:{$this->ano}:{$this->carrier_id}:{$this->tipo_servico}";
        $totals = Cache::remember($cacheKey, now()->addMinutes(15), function () {
            $query = \App\Models\Cdr::where('tempo_cobrado', '>', 1);

            if ($this->mes !== null && $this->mes !== '') {
                $query->whereRaw('EXTRACT(MONTH FROM calldate) = ?', [$this->mes]);
            }
            if ($this->ano !== null && $this->ano !== '') {
                $query->whereRaw('EXTRACT(YEAR FROM calldate) = ?', [$this->ano]);
            }
            if ($this->carrier_id !== null && $this->carrier_id !== '') {
                $query->where('carrier_id', $this->carrier_id);
            }
            if ($this->tipo_servico !== null && $this->tipo_servico !== '') {
                $query->where('tarifa', $this->tipo_servico);
            }

            return $query->selectRaw('
                COALESCE(SUM(tempo_cobrado), 0) as total_minutos,
                COALESCE(SUM(valor_compra), 0) as total_custo,
                COALESCE(AVG(valor_compra / NULLIF(tempo_cobrado, 0)), 0) as custo_medio_minuto
            ')->first();
        });

        // Cálculo do mês anterior para comparação (apenas se mês e ano estiverem definidos)
        $variacaoMinutos = 0;
        $variacaoCusto = 0;
        $mesAnterior = null;
        $anoAnterior = null;

        if ($this->mes !== null && $this->mes !== '' && $this->ano !== null && $this->ano !== '') {
            $mesAnterior = $this->mes - 1;
            $anoAnterior = $this->ano;
            if ($mesAnterior < 1) {
                $mesAnterior = 12;
                $anoAnterior = $this->ano - 1;
            }

            $cacheKeyAnterior = "carrier_reports_totals:{$mesAnterior}:{$anoAnterior}:{$this->carrier_id}:{$this->tipo_servico}";
            $totalsAnterior = Cache::remember($cacheKeyAnterior, now()->addMinutes(15), function () use ($mesAnterior, $anoAnterior) {
                $query = \App\Models\Cdr::where('tempo_cobrado', '>', 1)
                    ->whereRaw('EXTRACT(MONTH FROM calldate) = ?', [$mesAnterior])
                    ->whereRaw('EXTRACT(YEAR FROM calldate) = ?', [$anoAnterior]);

                if ($this->carrier_id !== null && $this->carrier_id !== '') {
                    $query->where('carrier_id', $this->carrier_id);
                }
                if ($this->tipo_servico !== null && $this->tipo_servico !== '') {
                    $query->where('tarifa', $this->tipo_servico);
                }

                return $query->selectRaw('
                    COALESCE(SUM(tempo_cobrado), 0) as total_minutos,
                    COALESCE(SUM(valor_compra), 0) as total_custo
                ')->first();
            });

            // Calcular variações
            if ($totalsAnterior && $totalsAnterior->total_minutos > 0) {
                $variacaoMinutos = (($totals->total_minutos ?? 0) - $totalsAnterior->total_minutos) / $totalsAnterior->total_minutos * 100;
            }
            if ($totalsAnterior && $totalsAnterior->total_custo > 0) {
                $variacaoCusto = (($totals->total_custo ?? 0) - $totalsAnterior->total_custo) / $totalsAnterior->total_custo * 100;
            }
        }

        return view('livewire.carriers.reports.index', compact(
            'reports',
            'carriers',
            'totals',
            'tiposServico',
            'variacaoMinutos',
            'variacaoCusto',
            'mesAnterior',
            'anoAnterior'
        ));
    }
}
