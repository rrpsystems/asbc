<?php

namespace App\Livewire\Invoices;

use App\Models\Cdr;
use App\Models\Did;
use App\Models\RevenueSummary;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoiceExport;

class Details extends Component
{
    public $invoiceId;
    public $invoice;
    public $dids;
    public $showDetailed = false; // Por padrão mostra resumo

    public function mount($invoiceId)
    {
        $this->invoiceId = $invoiceId;

        // Cache da fatura (não muda após criação) - 24 horas
        $this->invoice = Cache::remember("invoice:details:{$invoiceId}", now()->addHours(24), function () use ($invoiceId) {
            return RevenueSummary::with('customer')->findOrFail($invoiceId);
        });

        // Cache dos DIDs do cliente - 1 hora
        $this->dids = Cache::remember("invoice:dids:{$this->invoice->customer_id}", now()->addHour(), function () {
            return Did::where('customer_id', $this->invoice->customer_id)
                ->select('id', 'did', 'customer_id')
                ->get();
        });
    }

    /**
     * Alterna entre visualização resumida e detalhada
     */
    public function toggleDetailed()
    {
        $this->showDetailed = !$this->showDetailed;
    }

    /**
     * Limpa cache e força atualização
     */
    public function refreshData()
    {
        Cache::forget("invoice:details:{$this->invoiceId}");
        Cache::forget("invoice:calls:{$this->invoiceId}");
        Cache::forget("invoice:dids:{$this->invoice->customer_id}");

        $this->mount($this->invoiceId);
    }

    /**
     * Exporta a fatura resumida para PDF
     */
    public function exportPdfSummary()
    {
        $callsSummary = $this->getCallsSummary();

        $pdf = Pdf::loadView('livewire.invoices.pdf-summary', [
            'invoice' => $this->invoice,
            'dids' => $this->dids,
            'callsSummary' => $callsSummary,
        ]);

        $filename = "Fatura_Resumida_{$this->invoice->customer->razaosocial}_{$this->invoice->mes}_{$this->invoice->ano}.pdf";

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }

    /**
     * Exporta a fatura detalhada para PDF
     */
    public function exportPdfDetailed()
    {
        $calls = $this->getCalls();
        $callsSummary = $this->getCallsSummary();

        $pdf = Pdf::loadView('livewire.invoices.pdf', [
            'invoice' => $this->invoice,
            'dids' => $this->dids,
            'calls' => $calls,
            'callsSummary' => $callsSummary,
        ]);

        $filename = "Fatura_Detalhada_{$this->invoice->customer->razaosocial}_{$this->invoice->mes}_{$this->invoice->ano}.pdf";

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename);
    }

    /**
     * Exporta a fatura para Excel
     */
    public function exportExcel()
    {
        $filename = "Fatura_{$this->invoice->customer->razaosocial}_{$this->invoice->mes}_{$this->invoice->ano}.xlsx";

        return Excel::download(
            new InvoiceExport($this->invoiceId),
            $filename
        );
    }

    /**
     * Busca as chamadas com cache e paginação otimizada
     */
    private function getCalls()
    {
        // Cache das chamadas agrupadas - 6 horas (não mudam após fatura criada)
        return Cache::remember("invoice:calls:{$this->invoiceId}", now()->addHours(6), function () {
            // Query otimizada: agrupa no banco, não na collection
            return Cdr::where('customer_id', $this->invoice->customer_id)
                ->where('tempo_cobrado', '>', 1)
                ->whereMonth('calldate', $this->invoice->mes)
                ->whereYear('calldate', $this->invoice->ano)
                ->select([
                    'id',
                    'calldate',
                    'tempo_cobrado',
                    'tarifa',
                    'did_id',
                    'ramal',
                    'numero',
                    'valor_venda',
                    'cobrada',
                    'customer_id'
                ])
                ->orderBy('tarifa')
                ->orderBy('calldate')
                ->get()
                ->groupBy('tarifa');
        });
    }

    /**
     * Busca resumo consolidado das chamadas por tipo
     * Calcula DIRETAMENTE dos CDRs para garantir consistência total
     */
    private function getCallsSummary()
    {
        // Cria resumo calculando DIRETAMENTE dos CDRs
        $summary = collect();

        // Query base (filtra chamadas > 1 segundo, igual ao relatório detalhado)
        $baseQuery = Cdr::where('customer_id', $this->invoice->customer_id)
            ->where('tempo_cobrado', '>', 1)
            ->whereMonth('calldate', $this->invoice->mes)
            ->whereYear('calldate', $this->invoice->ano);

        // Fixo: mostra TODAS as chamadas (franquia + excedente)
        // Mas valor total considera apenas as cobradas
        $fixoData = (clone $baseQuery)->where('tarifa', 'Fixo')
            ->selectRaw('COUNT(*) as quantidade, SUM(tempo_cobrado) as total_segundos, SUM(CASE WHEN cobrada = \'S\' THEN valor_venda ELSE 0 END) as valor_total')
            ->first();

        if ($fixoData && $fixoData->quantidade > 0) {
            $summary->push((object)[
                'tarifa' => 'Fixo',
                'quantidade' => $fixoData->quantidade,
                'total_segundos' => $fixoData->total_segundos ?? 0,
                'valor_total' => $fixoData->valor_total ?? 0,
            ]);
        }

        // Móvel: mostra TODAS as chamadas (franquia + excedente)
        // Mas valor total considera apenas as cobradas
        $movelData = (clone $baseQuery)->where('tarifa', 'Movel')
            ->selectRaw('COUNT(*) as quantidade, SUM(tempo_cobrado) as total_segundos, SUM(CASE WHEN cobrada = \'S\' THEN valor_venda ELSE 0 END) as valor_total')
            ->first();

        if ($movelData && $movelData->quantidade > 0) {
            $summary->push((object)[
                'tarifa' => 'Movel',
                'quantidade' => $movelData->quantidade,
                'total_segundos' => $movelData->total_segundos ?? 0,
                'valor_total' => $movelData->valor_total ?? 0,
            ]);
        }

        // DDI/Internacional: mostra APENAS as chamadas COBRADAS (mesmo filtro do relatório)
        // Pois não tem franquia, tudo é excedente
        $internacionalData = (clone $baseQuery)->where('tarifa', 'Internacional')
            ->where('tempo_cobrado', '>', 1)
            ->where('cobrada', 'S')
            ->selectRaw('COUNT(*) as quantidade, SUM(tempo_cobrado) as total_segundos, SUM(valor_venda) as valor_total')
            ->first();

        if ($internacionalData && $internacionalData->quantidade > 0) {
            $summary->push((object)[
                'tarifa' => 'DDI',
                'quantidade' => $internacionalData->quantidade,
                'total_segundos' => $internacionalData->total_segundos ?? 0,
                'valor_total' => $internacionalData->valor_total ?? 0,
            ]);
        }

        return $summary;
    }

    public function render()
    {
        $calls = $this->getCalls();
        $callsSummary = $this->getCallsSummary();

        // Query base para excedentes (mesmo filtro do relatório detalhado)
        $baseExcedente = Cdr::where('customer_id', $this->invoice->customer_id)
            ->where('tempo_cobrado', '>', 1)
            ->whereMonth('calldate', $this->invoice->mes)
            ->whereYear('calldate', $this->invoice->ano)
            ->where('cobrada', 'S');

        // Conta por tipo
        $excedenteFixo = (clone $baseExcedente)->where('tarifa', 'Fixo')->count();
        $excedenteMovel = (clone $baseExcedente)->where('tarifa', 'Movel')->count();
        $excedenteDDI = (clone $baseExcedente)->where('tarifa', 'Internacional')->count();

        // Total de excedentes
        $excedenteQtd = $excedenteFixo + $excedenteMovel + $excedenteDDI;

        // Segundos totais de excedentes
        $excedenteSegundos = (clone $baseExcedente)->sum('tempo_cobrado') ?? 0;

        return view('livewire.invoices.details', [
            'calls' => $calls,
            'callsSummary' => $callsSummary,
            'excedenteQtd' => $excedenteQtd,
            'excedenteSegundos' => $excedenteSegundos,
        ]);
    }
}
