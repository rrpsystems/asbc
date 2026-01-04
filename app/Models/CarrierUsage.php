<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarrierUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'carrier_id',
        'tipo_servico',
        'mes',
        'ano',
        'franquia_minutos',
        'minutos_utilizados',
        'valor_plano',
        'custo_total',
        'fechado',
    ];

    protected $casts = [
        'fechado' => 'boolean',
    ];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }
}
