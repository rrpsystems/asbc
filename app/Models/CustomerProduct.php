<?php

namespace App\Models;

use App\Enums\TipoProduto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'tipo_produto',
        'descricao',
        'quantidade',
        'valor_custo_unitario',
        'valor_venda_unitario',
        'ativo',
        'data_ativacao',
        'data_cancelamento',
    ];

    protected $casts = [
        'tipo_produto' => TipoProduto::class,
        'quantidade' => 'integer',
        'valor_custo_unitario' => 'decimal:2',
        'valor_venda_unitario' => 'decimal:2',
        'ativo' => 'boolean',
        'data_ativacao' => 'date',
        'data_cancelamento' => 'date',
    ];

    /**
     * Relacionamento com Customer
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Scope para produtos ativos
     */
    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Scope por tipo de produto
     */
    public function scopeTipo($query, TipoProduto $tipo)
    {
        return $query->where('tipo_produto', $tipo);
    }

    /**
     * Calcula o custo total (quantidade × custo unitário)
     */
    public function getCustoTotalAttribute(): float
    {
        return $this->quantidade * $this->valor_custo_unitario;
    }

    /**
     * Calcula a receita total (quantidade × venda unitário)
     */
    public function getReceitaTotalAttribute(): float
    {
        return $this->quantidade * $this->valor_venda_unitario;
    }

    /**
     * Calcula o lucro do produto
     */
    public function getLucroAttribute(): float
    {
        return $this->receita_total - $this->custo_total;
    }

    /**
     * Calcula a margem de lucro (%)
     */
    public function getMargemAttribute(): float
    {
        if ($this->receita_total == 0) {
            return 0;
        }
        return ($this->lucro / $this->receita_total) * 100;
    }
}
