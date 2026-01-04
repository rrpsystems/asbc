<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reseller extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'razao_social',
        'cnpj',
        'email',
        'telefone',
        'endereco',
        'numero',
        'complemento',
        'cidade',
        'uf',
        'cep',
        'markup_chamadas',
        'markup_produtos',
        'markup_planos',
        'markup_dids',
        'valor_fixo_chamada',
        'valor_fixo_produto',
        'valor_fixo_plano',
        'valor_fixo_did',
        'ativo',
        'data_cadastro',
        'observacoes',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'markup_chamadas' => 'decimal:2',
        'markup_produtos' => 'decimal:2',
        'markup_planos' => 'decimal:2',
        'markup_dids' => 'decimal:2',
        'valor_fixo_chamada' => 'decimal:4',
        'valor_fixo_produto' => 'decimal:2',
        'valor_fixo_plano' => 'decimal:2',
        'valor_fixo_did' => 'decimal:2',
        'data_cadastro' => 'date',
    ];

    /**
     * Relacionamento: Revenda tem vários clientes
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Relacionamento: Revenda tem vários usuários
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Scope: Apenas revendas ativas
     */
    public function scopeAtivas($query)
    {
        return $query->where('ativo', true);
    }

    /**
     * Accessor: Total de clientes
     */
    public function getTotalCustomersAttribute(): int
    {
        return $this->customers()->count();
    }

    /**
     * Accessor: Clientes ativos
     */
    public function getActiveCustomersAttribute(): int
    {
        return $this->customers()->where('ativo', true)->count();
    }

    /**
     * Accessor: Receita mensal estimada (soma dos planos dos clientes)
     */
    public function getMonthlyRevenueAttribute(): float
    {
        return $this->customers()
            ->where('ativo', true)
            ->sum('valor_plano');
    }

    /**
     * Aplica markup a um valor base
     *
     * @param float $baseValue Valor base (sem markup)
     * @param string $type Tipo: 'chamadas', 'produtos', 'planos', 'dids'
     * @return float Valor com markup aplicado
     */
    public function applyMarkup(float $baseValue, string $type = 'chamadas'): float
    {
        $fixedField = "valor_fixo_{$type}";
        $markupField = "markup_{$type}";

        // Se tem valor fixo configurado, usa ele
        if (isset($this->$fixedField) && $this->$fixedField > 0) {
            return $this->$fixedField;
        }

        // Senão, aplica markup percentual
        $markup = $this->$markupField ?? 0;

        return $baseValue * (1 + ($markup / 100));
    }

    /**
     * Retorna informações de markup para um tipo de serviço
     *
     * @param string $type Tipo: 'chamadas', 'produtos', 'planos', 'dids'
     * @return array
     */
    public function getMarkupInfo(string $type = 'chamadas'): array
    {
        $fixedField = "valor_fixo_{$type}";
        $markupField = "markup_{$type}";

        $hasFixedValue = isset($this->$fixedField) && $this->$fixedField > 0;

        return [
            'type' => $type,
            'has_markup' => true,
            'markup_percent' => $this->$markupField ?? 0,
            'is_fixed_value' => $hasFixedValue,
            'fixed_value' => $hasFixedValue ? $this->$fixedField : null,
            'reseller_name' => $this->nome,
        ];
    }

    /**
     * Retorna resumo de todos os markups configurados
     *
     * @return array
     */
    public function getAllMarkups(): array
    {
        return [
            'chamadas' => $this->getMarkupInfo('chamadas'),
            'produtos' => $this->getMarkupInfo('produtos'),
            'planos' => $this->getMarkupInfo('planos'),
            'dids' => $this->getMarkupInfo('dids'),
        ];
    }
}
