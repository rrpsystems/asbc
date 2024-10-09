<?php

namespace App\Models;

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
        'fechado',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
