# Sistema de Revendas - Documentação Técnica

## Visão Geral

Sistema de gestão de revendas com autonomia para configurar markups e gerenciar clientes.

## Arquitetura de Dados

### Tabela: `resellers`
Armazena informações das revendas e seus markups.

**Campos principais:**
- `markup_chamadas` - Markup % para chamadas
- `markup_produtos` - Markup % para produtos/serviços
- `markup_planos` - Markup % para planos
- `markup_dids` - Markup % para DIDs
- `valor_fixo_*` - Valores fixos opcionais (sobrescreve markup %)

### Tabela: `customers`
- `reseller_id` (nullable) - FK para revendas

### Tabela: `users`
- `reseller_id` (nullable) - FK para revendas (usuários tipo RESELLER)
- `rule` - Enum incluindo RESELLER

### Tabela: `cdrs`
**Campos de valor (CRÍTICO):**

```sql
valor_compra        -- Custo da operadora (ex: R$ 0,08)
valor_venda         -- SEU preço de venda (o que revenda PAGA para você) (ex: R$ 0,10)
valor_venda_final   -- Preço final com markup (o que revenda COBRA do cliente) (ex: R$ 0,15)
valor_markup        -- Lucro da revenda (venda_final - venda) (ex: R$ 0,05)
```

**Importante:**
- `valor_venda_final` e `valor_markup` são NULL quando cliente não tem revenda
- `valor_venda` SEMPRE contém o valor base (sem markup)

## Fluxo de Cálculo

### 1. Processamento de CDR (CallTariffService)

```php
// Cliente DIRETO
valor_compra = 0.08
valor_venda = 0.10
valor_venda_final = NULL
valor_markup = NULL

// Cliente de REVENDA (markup 50%)
valor_compra = 0.08
valor_venda = 0.10          // Você recebe da revenda
valor_venda_final = 0.15    // Revenda cobra do cliente
valor_markup = 0.05         // Lucro da revenda
```

### 2. Cálculo de Markup

**PriceCalculationService:**
```php
$basePrice = 0.10;  // Seu preço
$markup = 50%;      // Configurado pela revenda

$finalPrice = $basePrice * (1 + $markup/100);
// = 0.10 * 1.50 = 0.15
```

**Ou valor fixo:**
```php
$fixedValue = 0.20;  // Revenda configurou valor fixo
$finalPrice = $fixedValue;  // Ignora markup %
```

### 3. Revenue Summary

**Usa `valor_venda` (não o final):**
- Você fatura baseado em `SUM(valor_venda)`
- Revenda fatura clientes baseado em `SUM(valor_venda_final)`

## Controles Financeiros

### Para VOCÊ (Admin):

**Receita da Revenda:**
```sql
SELECT SUM(valor_venda) as total_a_receber
FROM cdrs
WHERE customer_id IN (
    SELECT id FROM customers WHERE reseller_id = ?
)
```

**Lucro da Revenda (para auditoria):**
```sql
SELECT SUM(valor_markup) as lucro_revenda
FROM cdrs
WHERE customer_id IN (
    SELECT id FROM customers WHERE reseller_id = ?
)
```

### Para REVENDA:

**A pagar para você:**
```sql
SELECT SUM(valor_venda) as total_a_pagar
FROM cdrs
WHERE customer_id IN (meus_clientes)
```

**A receber dos clientes:**
```sql
SELECT SUM(valor_venda_final) as total_a_receber
FROM cdrs
WHERE customer_id IN (meus_clientes)
```

**Meu lucro:**
```sql
SELECT SUM(valor_markup) as meu_lucro
FROM cdrs
WHERE customer_id IN (meus_clientes)
```

## Permissões

### UserRole::ADMIN
- ✅ Vê todos os valores (compra, venda, venda_final, markup)
- ✅ Cria e edita revendas
- ✅ Define markup inicial das revendas
- ✅ Vê relatórios de comissão

### UserRole::RESELLER
- ✅ Configura seus próprios markups
- ✅ Vê clientes da sua revenda
- ✅ Vê quanto deve pagar (valor_venda)
- ✅ Vê quanto vai receber (valor_venda_final)
- ✅ Vê seu lucro (valor_markup)
- ❌ NÃO vê valor_compra (custo da operadora)

### UserRole::MANAGER (Cliente)
- ✅ Vê apenas valor final cobrado dele
- ❌ NÃO vê custos nem markups

## Relatórios Admin

### 1. Faturamento por Revenda
```sql
SELECT
    r.nome,
    COUNT(DISTINCT c.id) as total_clientes,
    SUM(cdr.valor_venda) as receita_revenda,
    SUM(cdr.valor_markup) as lucro_revenda,
    SUM(cdr.valor_venda_final) as faturamento_clientes
FROM resellers r
JOIN customers c ON c.reseller_id = r.id
JOIN cdrs cdr ON cdr.customer_id = c.id
GROUP BY r.id
```

### 2. Top Revendas por Lucro
```sql
SELECT
    r.nome,
    SUM(cdr.valor_markup) as lucro_total
FROM resellers r
JOIN customers c ON c.reseller_id = r.id
JOIN cdrs cdr ON cdr.customer_id = c.id
GROUP BY r.id
ORDER BY lucro_total DESC
LIMIT 10
```

## Migration Script (SBC)

Para adicionar campos no SBC (Asterisk):

```sql
ALTER TABLE cdrs
ADD COLUMN valor_venda_final DECIMAL(10,4) DEFAULT NULL,
ADD COLUMN valor_markup DECIMAL(10,4) DEFAULT NULL;

COMMENT ON COLUMN cdrs.valor_venda_final IS 'Valor final cobrado (com markup revenda)';
COMMENT ON COLUMN cdrs.valor_markup IS 'Diferença entre valor_venda_final e valor_venda (lucro da revenda)';
```

## Exemplo Completo

**Cenário:**
- Revenda XYZ
- Markup: 20% chamadas, 30% produtos
- Cliente ABC (pertence à Revenda XYZ)

**Chamada:**
1. Custo operadora: R$ 0,08
2. Seu preço: R$ 0,10
3. Markup 20%: R$ 0,10 × 1,20 = R$ 0,12
4. CDR salvo:
   - valor_compra = 0.08
   - valor_venda = 0.10
   - valor_venda_final = 0.12
   - valor_markup = 0.02

**Produto mensal (R$ 50,00):**
1. Seu preço: R$ 50,00
2. Markup 30%: R$ 50 × 1,30 = R$ 65,00
3. Revenue summary:
   - produtos_custo = 50.00
   - produtos_receita = 65.00 (calculado em tempo real)

**Faturamento:**
- Cliente ABC paga para Revenda XYZ: R$ 65,12
- Revenda XYZ paga para você: R$ 60,10
- Lucro Revenda XYZ: R$ 5,02

## Notas Importantes

1. **Markup é fixado no momento da chamada**
   - Alterar markup não afeta CDRs já processados
   - Apenas novas chamadas usam novo markup

2. **Valor base sempre preservado**
   - `valor_venda` nunca muda
   - Garantia de quanto revenda deve pagar

3. **Auditoria completa**
   - Admin vê todos os valores
   - Transparência total para contestações

4. **Autonomia da revenda**
   - Revenda define seus próprios markups
   - Você não interfere nos preços dela
   - Você só garante seu valor base
