<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cnpj',
        'razaosocial',
        'nomefantasia',
        'endereco',
        'numero',
        'complemento',
        'cidade',
        'uf',
        'cep',
        'canais',
        'valor_plano',
        'franquia_minutos',
        'valor_excedente',
        'data_inicio',
        'data_fim',
        'email',
        'telefone',
        'senha',
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    public function dids()
    {
        return $this->hasMany(Did::class);
    }

    public function revenueSummaries()
    {
        return $this->hasMany(RevenueSummary::class);
    }
}
