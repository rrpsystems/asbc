<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'reseller_id',
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
        'vencimento',
        'data_inicio',
        'data_fim',
        'email',
        'telefone',
        'senha',
        'ativo',
        'proxy_padrao',
        'porta_padrao',
        'bloqueio_entrada',
        'bloqueio_saida',
        'motivo_bloqueio',
        'data_bloqueio',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'bloqueio_entrada' => 'boolean',
        'bloqueio_saida' => 'boolean',
        'data_bloqueio' => 'datetime',
    ];

    public function dids()
    {
        return $this->hasMany(Did::class);
    }

    public function revenueSummaries()
    {
        return $this->hasMany(RevenueSummary::class);
    }

    public function products()
    {
        return $this->hasMany(CustomerProduct::class);
    }

    public function produtosAtivos()
    {
        return $this->hasMany(CustomerProduct::class)->where('ativo', true);
    }

    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }

    /**
     * Verifica se o cliente pertence a uma revenda
     */
    public function hasReseller(): bool
    {
        return !is_null($this->reseller_id);
    }

    /**
     * Retorna o markup aplicado para um tipo de serviço
     */
    public function getMarkupForService(string $serviceType): float
    {
        if (!$this->hasReseller()) {
            return 0;
        }

        $markupField = "markup_{$serviceType}";
        return $this->reseller->$markupField ?? 0;
    }
}
