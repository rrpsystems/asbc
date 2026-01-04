# Análise do CarrierUsageService - Uso de Operadoras

**Data**: 2025-12-27
**Versão Laravel**: 12.42.0
**Banco de Dados**: PostgreSQL

## 📋 Visão Geral

O `CarrierUsageService` é responsável por rastrear e consolidar o uso de operadoras (carriers), calculando minutos utilizados e custos totais por mês. Relaciona-se com o `CarrierCostAllocationService` que faz análises mais complexas de rateio.

## 🔍 Componentes Analisados

### 1. CarrierUsageService.php
**Localização**: `app/Services/CarrierUsageService.php`

#### Métodos:

##### `atualizarResumo($cdr)` - Linhas 14-37
**Propósito**: Atualiza resumo de uso quando um CDR é processado

**Problemas Identificados**:

❌ **CRÍTICO - Race Condition**
```php
$resumo->minutos_utilizados += $cdr->tempo_cobrado;
$resumo->custo_total += $cdr->valor_compra;
$resumo->save();
```
- Mesmo problema do `MonthlyRevenueSummaryService`
- Múltiplos jobs podem ler e gravar simultaneamente
- Perda de dados garantida em ambiente concorrente

❌ **DESIGN PROBLEM - Chamado por CDR individual**
- Atualiza a cada CDR processado
- Performance ruim (1 write por chamada)
- Deveria usar batch processing

❌ **Parsing repetitivo de data**
```php
'mes' => Carbon::parse($cdr->calldate)->month,
'ano' => Carbon::parse($cdr->calldate)->year,
```
- Carbon::parse executado 2 vezes
- Poderia cachear o resultado

⚠️ **Inconsistência com campos**
```php
'franquia_minutos' => 0,
'valor_plano' => 0,
```
- Define valores padrão que nunca são atualizados
- Campos existem mas não são utilizados
- `tipo_servico` adicionado em migration mas não usado aqui

##### `recalcularMes($mes, $ano, $carrierId = null)` - Linhas 42-79
**Propósito**: Recalcula resumos do mês baseado nos CDRs

**Problemas Identificados**:

⚠️ **Inconsistência de agregação**
```php
$resumos = $query->selectRaw('
    carrier_id,
    tarifa as tipo_servico,
    SUM(tempo_cobrado) as total_minutos,
    SUM(valor_compra) as total_custo
')
->groupBy('carrier_id', 'tarifa')
```
- Agrupa por `carrier_id` + `tarifa` (tipo_servico)
- Mas `atualizarResumo()` NÃO usa `tipo_servico`
- Dados são salvos de forma diferente!

❌ **Sobrescreve dados existentes**
```php
CarrierUsage::updateOrCreate(
    [
        'carrier_id' => $resumo->carrier_id,
        'tipo_servico' => $resumo->tipo_servico, // ← Usado aqui
        'mes' => $mes,
        'ano' => $ano,
    ],
    // ...
);
```
- `atualizarResumo()` cria sem `tipo_servico`
- `recalcularMes()` agrupa POR `tipo_servico`
- Podem criar registros duplicados/inconsistentes

⚠️ **Falta validação**
- Não valida se `mes` está entre 1-12
- Não valida se `ano` é válido
- Aceita valores negativos ou inválidos

## 🔗 Relacionamento com CarrierCostAllocationService

O `CarrierCostAllocationService` é MUITO mais robusto e completo:

### Diferenças Principais:

| Aspecto | CarrierUsageService | CarrierCostAllocationService |
|---------|-------------------|----------------------------|
| **Propósito** | Rastrear uso bruto | Calcular custos reais + rateio |
| **Complexidade** | Simples (minutos + custo) | Complexo (franquia + fixo + variável) |
| **Queries** | Não otimizadas | Otimizadas com agregações |
| **Funcionalidades** | Básicas | Avançadas (rateio por DID/cliente) |
| **Uso** | Aparentemente obsoleto | Usado ativamente no dashboard |

### CarrierCostAllocationService faz:
1. ✅ Calcula custo fixo vs variável
2. ✅ Considera franquia compartilhada ou separada
3. ✅ Rateia custos por DID e por cliente
4. ✅ Analisa eficiência (DIDs ociosos)
5. ✅ Detalhamento por tipo de chamada
6. ✅ Queries otimizadas com agregação

### CarrierUsageService faz:
1. Soma minutos e custos brutos
2. Race conditions garantidas
3. Performance ruim
4. Duplicação de dados

## 🚨 Problemas Críticos

### 1. **NUNCA É CHAMADO** ❌❌❌
Analisando o código:
- ✅ `recalcularMes()` é chamado pelos comandos
- ❌ `atualizarResumo()` NUNCA é chamado!

**Evidências**:
```bash
grep -r "atualizarResumo.*carrier" → Nenhum resultado
grep -r "CarrierUsageService" → Apenas comandos console
```

Verificando `CallTariffJob.php`:
- ✅ Chama `RevenueBatchDispatcher` (resumo de cliente)
- ❌ NÃO chama `CarrierUsageService`

**Conclusão**: O método `atualizarResumo()` está MORTO no código!

### 2. **Duplicação de Responsabilidade**

`CarrierUsageService` tenta fazer o que `CarrierCostAllocationService` já faz melhor:

```php
// CarrierUsageService (simples, bugado)
$resumo->custo_total += $cdr->valor_compra;

// CarrierCostAllocationService (completo, correto)
return [
    'custo_variavel' => $custoVariavel,
    'custo_fixo' => $custoFixo,
    'custo_total' => $custoVariavel + $custoFixo,
    'detalhes' => $this->detalharCustos(...),
];
```

### 3. **Tabela carrier_usages Subutilizada**

A tabela existe com campos:
- `carrier_id`, `tipo_servico`, `mes`, `ano`
- `franquia_minutos`, `minutos_utilizados`
- `valor_plano`, `custo_total`, `fechado`

Mas apenas `recalcularMes()` a usa, e de forma inconsistente.

### 4. **Inconsistência com Migration**

Migration `2025_10_23_204732_add_tipo_servico_to_carrier_usages_table.php`:
- Adiciona campo `tipo_servico`
- Mas `atualizarResumo()` não o usa
- `recalcularMes()` usa, criando inconsistência

## 📊 Uso Atual

### Comandos que Usam o Service:

1. **`operadora:processar-mensal`** (agendado)
   - Roda no dia 1 de cada mês às 6h
   - Chama `recalcularMes()` para mês anterior
   - Usado para fechamento mensal

2. **`operadora:gerar-relatorio`** (manual)
   - Permite recalcular mês específico
   - Permite filtrar por carrier_id
   - Usado para reprocessamento

### Onde os Dados são Usados:

Procurando por `CarrierUsage::`:
- ✅ `FecharFaturasMensalCommand.php` - Fecha faturas
- ✅ `ReabrirFaturaCommand.php` - Reabre faturas
- ❓ Possivelmente relatórios (não verificado ainda)

**Importante**: Dashboard Financeiro usa `CarrierCostAllocationService`, NÃO `CarrierUsageService`!

## 💡 Recomendações

### Opção 1: DEPRECAR CarrierUsageService ⭐ RECOMENDADO

**Motivos**:
1. `CarrierCostAllocationService` faz tudo que ele faz e MUITO mais
2. `atualizarResumo()` nunca é chamado (código morto)
3. `recalcularMes()` pode ser movido para `CarrierCostAllocationService`
4. Elimina duplicação de código
5. Elimina tabela subutilizada

**Passos**:
1. Migrar funcionalidade de `recalcularMes()` para `CarrierCostAllocationService`
2. Atualizar comandos para usar o novo service
3. Deprecar `CarrierUsageService`
4. Avaliar se tabela `carrier_usages` ainda é necessária

### Opção 2: Integrar com Batch Processing (se manter)

Se decidirem MANTER o service:

1. **Remover `atualizarResumo()`** - está morto mesmo
2. **Melhorar `recalcularMes()`**:
   - Decidir se agrupa por `tipo_servico` ou não
   - Adicionar validações
   - Usar transações
   - Cache de resultados
3. **Adicionar batch processing** similar ao `RevenueBatchDispatcher`
4. **Corrigir race conditions** com locks e atomic updates

### Opção 3: Consolidar Ambos Services

Criar um **`CarrierReportingService`** único que:
- Mantém funcionalidade completa do `CarrierCostAllocationService`
- Adiciona persistência mensal (se necessário)
- Elimina duplicação
- Interface unificada

## 🎯 Perguntas Críticas

Antes de implementar qualquer solução:

1. ❓ A tabela `carrier_usages` é realmente necessária?
   - `CarrierCostAllocationService` calcula tudo on-demand
   - Pode ser mais lento, mas sempre preciso

2. ❓ Os comandos de fechamento de fatura PRECISAM dessa tabela?
   - Ou podem usar `CarrierCostAllocationService` diretamente?

3. ❓ Existe algum relatório que depende de `carrier_usages`?
   - Preciso verificar controllers e livewire components

4. ❓ O campo `fechado` é usado?
   - Para marcar meses que já foram faturados?

## 📈 Impacto da Mudança

### Se DEPRECAR:
- ✅ Elimina código morto
- ✅ Reduz complexidade
- ✅ Melhora manutenibilidade
- ⚠️ Precisa migrar comandos
- ⚠️ Pode impactar relatórios existentes

### Se MANTER e MELHORAR:
- ✅ Mantém histórico em tabela
- ✅ Queries mais rápidas (dados pré-calculados)
- ⚠️ Precisa corrigir race conditions
- ⚠️ Precisa sincronizar com batch de CDRs
- ⚠️ Duplicação com `CarrierCostAllocationService`

## 🔄 Próximos Passos Sugeridos

1. **Investigar dependências**
   - Verificar todos os usos de `carrier_usages`
   - Verificar relatórios que podem depender dela
   - Confirmar se campo `fechado` é usado

2. **Decidir arquitetura**
   - Manter tabela ou calcular on-demand?
   - Consolidar com `CarrierCostAllocationService`?
   - Deprecar completamente?

3. **Implementar solução escolhida**
   - Migrar comandos se necessário
   - Adicionar testes
   - Documentar mudanças

---

**Conclusão**: O `CarrierUsageService` parece ser um **código legado** que foi **parcialmente substituído** pelo `CarrierCostAllocationService` mais robusto, mas nunca totalmente removido. Recomendo fortemente **consolidar ambos** ou **deprecar o antigo**.
