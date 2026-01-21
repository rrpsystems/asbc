<?php

namespace App\Exports;

use App\Models\Cdr;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QualityAnalysisExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $data_inicial;
    protected $data_final;
    protected $group_by;

    public function __construct($data_inicial, $data_final, $group_by)
    {
        $this->data_inicial = $data_inicial;
        $this->data_final = $data_final;
        $this->group_by = $group_by;
    }

    public function query()
    {
        $query = Cdr::query()
            ->whereBetween('calldate', [
                $this->data_inicial . ' 00:00:00',
                $this->data_final . ' 23:59:59'
            ]);

        if ($this->group_by === 'customer') {
            return $query->select([
                'customer_id',
                DB::raw('MAX(customers.razaosocial) as nome'),
                DB::raw('COUNT(*) as total_chamadas'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_atendidas'),
                DB::raw('SUM(CASE WHEN disposition != \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_nao_atendidas'),
                DB::raw('ROUND((SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END)::numeric / NULLIF(COUNT(*), 0)) * 100, 2) as asr'),
                DB::raw('ROUND(AVG(CASE WHEN disposition = \'ANSWERED\' AND billsec > 0 THEN billsec ELSE NULL END), 0) as acd'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN billsec ELSE 0 END) as total_duracao'),
            ])
                ->join('customers', 'cdrs.customer_id', '=', 'customers.id')
                ->groupBy('customer_id')
                ->orderBy('asr', 'DESC');
        } elseif ($this->group_by === 'carrier') {
            return $query->select([
                'carrier_id',
                DB::raw('MAX(carriers.operadora) as nome'),
                DB::raw('COUNT(*) as total_chamadas'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_atendidas'),
                DB::raw('SUM(CASE WHEN disposition != \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_nao_atendidas'),
                DB::raw('ROUND((SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END)::numeric / NULLIF(COUNT(*), 0)) * 100, 2) as asr'),
                DB::raw('ROUND(AVG(CASE WHEN disposition = \'ANSWERED\' AND billsec > 0 THEN billsec ELSE NULL END), 0) as acd'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN billsec ELSE 0 END) as total_duracao'),
            ])
                ->join('carriers', 'cdrs.carrier_id', '=', 'carriers.id')
                ->groupBy('carrier_id')
                ->orderBy('asr', 'DESC');
        } else { // daily
            return $query->select([
                DB::raw('DATE(calldate) as data'),
                DB::raw('DATE(calldate) as nome'),
                DB::raw('COUNT(*) as total_chamadas'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_atendidas'),
                DB::raw('SUM(CASE WHEN disposition != \'ANSWERED\' THEN 1 ELSE 0 END) as chamadas_nao_atendidas'),
                DB::raw('ROUND((SUM(CASE WHEN disposition = \'ANSWERED\' THEN 1 ELSE 0 END)::numeric / NULLIF(COUNT(*), 0)) * 100, 2) as asr'),
                DB::raw('ROUND(AVG(CASE WHEN disposition = \'ANSWERED\' AND billsec > 0 THEN billsec ELSE NULL END), 0) as acd'),
                DB::raw('SUM(CASE WHEN disposition = \'ANSWERED\' THEN billsec ELSE 0 END) as total_duracao'),
            ])
                ->groupBy(DB::raw('DATE(calldate)'))
                ->orderBy(DB::raw('DATE(calldate)'), 'DESC');
        }
    }

    public function headings(): array
    {
        $label = $this->group_by === 'customer' ? 'Cliente'
            : ($this->group_by === 'carrier' ? 'Operadora' : 'Data');

        return [
            $label,
            'Total Chamadas',
            'Chamadas Atendidas',
            'Chamadas Não Atendidas',
            'ASR (%)',
            'ACD (segundos)',
            'Duração Total (HH:MM:SS)',
            'Classificação ASR',
        ];
    }

    public function map($item): array
    {
        $classificacao = $item->asr >= 50 ? 'Excelente'
            : ($item->asr >= 30 ? 'Aceitável' : 'Crítico');

        $nome = $this->group_by === 'daily'
            ? date('d/m/Y', strtotime($item->data))
            : $item->nome;

        return [
            $nome,
            $item->total_chamadas,
            $item->chamadas_atendidas,
            $item->chamadas_nao_atendidas,
            number_format($item->asr, 2, ',', '.') . '%',
            gmdate('i:s', $item->acd) . ' min',
            number_format($item->total_duracao / 60, 0) . ' min',
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
