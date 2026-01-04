<?php

namespace App\Exports;

use App\Models\Cdr;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CdrsExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Cdr::query()
            ->with(['customer:id,razaosocial', 'carrier:id,operadora']);

        // Aplica os mesmos filtros da listagem
        if (!empty($this->filters['data_inicial']) && !empty($this->filters['data_final'])) {
            $query->whereBetween('calldate', [$this->filters['data_inicial'], $this->filters['data_final']]);
        }

        if (!empty($this->filters['carrier'])) {
            $query->whereIn('carrier_id', $this->filters['carrier']);
        }

        if (!empty($this->filters['customer'])) {
            $query->whereIn('customer_id', $this->filters['customer']);
        }

        if (!empty($this->filters['did'])) {
            $query->whereIn('did_id', $this->filters['did']);
        }

        if (!empty($this->filters['tarifa'])) {
            $query->whereIn('tarifa', $this->filters['tarifa']);
        }

        if (!empty($this->filters['desligamento'])) {
            $query->whereIn('desligamento', $this->filters['desligamento']);
        }

        if (!empty($this->filters['stat'])) {
            $query->whereIn('status', $this->filters['stat']);
        }

        if (!empty($this->filters['ramal'])) {
            $query->where('ramal', 'like', '%' . $this->filters['ramal'] . '%');
        }

        if (!empty($this->filters['numero'])) {
            $query->where('numero', 'like', '%' . $this->filters['numero'] . '%');
        }

        return $query->orderBy('calldate', 'DESC');
    }

    public function headings(): array
    {
        return [
            'Data/Hora',
            'DID',
            'Cliente',
            'Número',
            'Tarifa',
            'Tempo Cobrado (seg)',
            'Valor Compra (R$)',
            'Valor Venda (R$)',
            'Ramal',
            'Duração (seg)',
            'Desconexão',
            'Status',
            'Operadora',
            'Disposition',
        ];
    }

    public function map($cdr): array
    {
        return [
            $cdr->calldate ? date('d/m/Y H:i:s', strtotime($cdr->calldate)) : '',
            $cdr->did_id,
            $cdr->customer->razaosocial ?? '',
            $cdr->numero,
            $cdr->tarifa,
            $cdr->tempo_cobrado ?? 0,
            number_format($cdr->valor_compra ?? 0, 4, ',', '.'),
            number_format($cdr->valor_venda ?? 0, 4, ',', '.'),
            $cdr->ramal,
            $cdr->billsec ?? 0,
            $cdr->desligamento,
            $cdr->status,
            $cdr->carrier->operadora ?? '',
            $cdr->disposition,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo do cabeçalho
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ],
            ],
        ];
    }
}
