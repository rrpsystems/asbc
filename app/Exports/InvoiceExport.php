<?php

namespace App\Exports;

use App\Models\Cdr;
use App\Models\Did;
use App\Models\RevenueSummary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class InvoiceExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, ShouldAutoSize
{
    protected $invoiceId;
    protected $invoice;
    protected $rowNumber = 0;

    public function __construct($invoiceId)
    {
        $this->invoiceId = $invoiceId;
        $this->invoice = RevenueSummary::with('customer')->findOrFail($invoiceId);
    }

    /**
     * Retorna a coleção de chamadas
     */
    public function collection()
    {
        return Cdr::where('customer_id', $this->invoice->customer_id)
            ->where('tempo_cobrado', '>', 1)
            ->whereMonth('calldate', $this->invoice->mes)
            ->whereYear('calldate', $this->invoice->ano)
            ->select([
                'calldate',
                'tempo_cobrado',
                'tarifa',
                'did_id',
                'ramal',
                'numero',
                'valor_venda',
                'cobrada'
            ])
            ->orderBy('tarifa')
            ->orderBy('calldate')
            ->get();
    }

    /**
     * Cabeçalhos das colunas
     */
    public function headings(): array
    {
        // Informações da fatura no topo
        return [
            ['FATURA #' . str_pad($this->invoiceId, 5, '0', STR_PAD_LEFT)],
            ['Cliente: ' . ($this->invoice->customer->razaosocial ?? '')],
            ['Competência: ' . str_pad($this->invoice->mes, 2, '0', STR_PAD_LEFT) . '/' . $this->invoice->ano],
            ['Vencimento: ' . $this->invoice->dataVencimento($this->invoice->customer->vencimento . '/' . $this->invoice->mes . '/' . $this->invoice->ano)],
            [''],
            // Cabeçalhos da tabela de chamadas
            [
                'DATA',
                'HORA',
                'DURAÇÃO',
                'TIPO',
                'ORIGEM',
                'RAMAL',
                'TELEFONE',
                'VALOR'
            ]
        ];
    }

    /**
     * Mapeia cada linha da chamada
     */
    public function map($call): array
    {
        $this->rowNumber++;

        return [
            date('d/m/Y', strtotime($call->calldate)),
            date('H:i', strtotime($call->calldate)),
            \Carbon\Carbon::createFromFormat('U', $call->tempo_cobrado ?? '0')->format('H\hi\ms\s'),
            $call->tarifa,
            $call->did_id,
            $call->ramal,
            $call->numero,
            strtoupper($call->cobrada) == 'S' ? number_format($call->valor_venda, 2, ',', '.') : '0,00'
        ];
    }

    /**
     * Nome da planilha
     */
    public function title(): string
    {
        return 'Fatura ' . $this->invoice->mes . '/' . $this->invoice->ano;
    }

    /**
     * Estilos da planilha
     */
    public function styles(Worksheet $sheet)
    {
        // Estilos do cabeçalho (primeiras 4 linhas)
        $sheet->getStyle('A1:A4')->getFont()->setBold(true)->setSize(12);

        // Estilo do cabeçalho da tabela (linha 6)
        $sheet->getStyle('A6:H6')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '2563EB'], // Azul
            ],
        ]);

        // Adiciona totais no final
        $lastRow = $this->rowNumber + 7;
        $sheet->setCellValue("A{$lastRow}", 'TOTAIS');
        $sheet->setCellValue("B{$lastRow}", 'Valor Plano:');
        $sheet->setCellValue("C{$lastRow}", 'R$ ' . number_format($this->invoice->valor_plano, 2, ',', '.'));

        if ($this->invoice->custo_excedente > 0) {
            $lastRow++;
            $sheet->setCellValue("B{$lastRow}", 'Excedente:');
            $sheet->setCellValue("C{$lastRow}", 'R$ ' . number_format($this->invoice->custo_excedente, 2, ',', '.'));
        }

        $lastRow++;
        $sheet->setCellValue("B{$lastRow}", 'TOTAL:');
        $sheet->setCellValue("C{$lastRow}", 'R$ ' . number_format($this->invoice->custo_total, 2, ',', '.'));
        $sheet->getStyle("A{$lastRow}:C{$lastRow}")->getFont()->setBold(true);

        return [];
    }
}
