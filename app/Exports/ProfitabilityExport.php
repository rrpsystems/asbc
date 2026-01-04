<?php

namespace App\Exports;

use App\Models\RevenueSummary;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfitabilityExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $mes;
    protected $ano;

    public function __construct($mes, $ano)
    {
        $this->mes = $mes;
        $this->ano = $ano;
    }

    public function query()
    {
        return RevenueSummary::query()
            ->select([
                'revenue_summaries.*',
                'customers.razaosocial',
                'customers.nomefantasia',
                DB::raw('COALESCE(revenue_summaries.receita_total, revenue_summaries.custo_total) as receita_final'),
                DB::raw('COALESCE(revenue_summaries.receita_total, revenue_summaries.custo_total) - revenue_summaries.custo_total as margem_lucro'),
                DB::raw('CASE
                    WHEN revenue_summaries.custo_total > 0 THEN
                        ((COALESCE(revenue_summaries.receita_total, revenue_summaries.custo_total) - revenue_summaries.custo_total) / revenue_summaries.custo_total) * 100
                    ELSE 0
                END as percentual_rentabilidade')
            ])
            ->join('customers', 'revenue_summaries.customer_id', '=', 'customers.id')
            ->where('revenue_summaries.mes', $this->mes)
            ->where('revenue_summaries.ano', $this->ano)
            ->where('customers.ativo', true)
            ->orderBy('margem_lucro', 'DESC');
    }

    public function headings(): array
    {
        return [
            'Cliente',
            'Nome Fantasia',
            'Receita Total (R$)',
            'Custo Total (R$)',
            'Produtos/Serviços (R$)',
            'Margem de Lucro (R$)',
            'Rentabilidade (%)',
            'Classificação',
        ];
    }

    public function map($item): array
    {
        $classificacao = $item->percentual_rentabilidade >= 20 ? 'Excelente'
            : ($item->percentual_rentabilidade >= 10 ? 'Bom' : 'Atenção');

        return [
            $item->razaosocial,
            $item->nomefantasia ?? '-',
            number_format($item->receita_final, 2, ',', '.'),
            number_format($item->custo_total, 2, ',', '.'),
            number_format($item->produtos_receita ?? 0, 2, ',', '.'),
            number_format($item->margem_lucro, 2, ',', '.'),
            number_format($item->percentual_rentabilidade, 2, ',', '.') . '%',
            $classificacao,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
