<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'mes',
        'ano',
        'franquia_minutos',
        'minutos_fixo',
        'minutos_movel',
        'minutos_internacional',
        'minutos_usados',
        'minutos_excedentes',
        'minutos_excedentes_fixo',
        'minutos_excedentes_movel',
        'minutos_excedentes_internacional',
        'minutos_total',
        'valor_plano',
        'excedente_fixo',
        'excedente_movel',
        'excedente_internacional',
        'excedente_total',
        'custo_excedente',
        'custo_total',
        'produtos_receita',
        'produtos_custo',
        'receita_total',
        'fechado',
    ];

    protected $casts = [
        'produtos_receita' => 'decimal:2',
        'produtos_custo' => 'decimal:2',
        'receita_total' => 'decimal:2',
        'fechado' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function dataVencimento($data)
    {
        return Carbon::createFromFormat('d/m/Y', $data)->addMonth()->format('d/m/Y');
    }
}
