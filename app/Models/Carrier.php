<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'operadora',
        'canais',
        'data_inicio',
        'ativo',
        'proxy',
        'porta',
        'valor_plano_mensal',
        'dids_inclusos',
        'franquia_valor_fixo',
        'franquia_valor_movel',
        'franquia_valor_nacional',
        'franquia_compartilhada',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'franquia_compartilhada' => 'boolean',
        'valor_plano_mensal' => 'decimal:2',
        'franquia_valor_fixo' => 'decimal:2',
        'franquia_valor_movel' => 'decimal:2',
        'franquia_valor_nacional' => 'decimal:2',
    ];
}
