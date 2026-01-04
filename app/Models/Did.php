<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Did extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'carrier_id',
        'did',
        'encaminhamento',
        'descricao',
        'valor_mensal',
        'data_ativacao',
        'ativo',
        'proxy',
        'porta',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'valor_mensal' => 'decimal:2',
        'data_ativacao' => 'date',
    ];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function calls()
    {
        return $this->hasMany(Cdr::class);
    }

    /**
     * Retorna o proxy ativo (específico do DID ou padrão do customer)
     */
    public function getProxyAtivo()
    {
        return $this->proxy ?? $this->customer?->proxy_padrao;
    }

    /**
     * Retorna a porta ativa (específica do DID ou padrão do customer)
     */
    public function getPortaAtiva()
    {
        return $this->porta ?? $this->customer?->porta_padrao ?? 5060;
    }

    /**
     * Accessor para usar facilmente nos Blade templates
     */
    protected $appends = ['proxy_ativo', 'porta_ativa'];

    public function getProxyAtivoAttribute()
    {
        return $this->getProxyAtivo();
    }

    public function getPortaAtivaAttribute()
    {
        return $this->getPortaAtiva();
    }

    /**
     * Verifica se está usando configuração específica ou herdada
     */
    public function usaConfiguracaoEspecifica()
    {
        return !is_null($this->proxy) || !is_null($this->porta);
    }
}
