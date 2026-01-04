# Análise: CarrierCostAllocationService

**Data**: 2025-12-27
**Versão Laravel**: 12.42.0
**Status**: 🔍 EM ANÁLISE

## 📋 Resumo Executivo

O `CarrierCostAllocationService` é um **service robusto e bem arquitetado** que gerencia cálculos complexos de custos de operadoras, incluindo custos fixos, variáveis, franquias compartilhadas/separadas, e rateios por cliente e DID.

## 🎯 Funcionalidades

### Métodos Principais:

1. **`calcularCustoReal($carrierId, $mes, $ano)`**
   - Calcula custo total (fixo + variável) de uma operadora
   - Retorna: `custo_variavel`, `custo_fixo`, `custo_total`, `detalhes`

2. **`calcularCustoVariavel($carrierId, $mes, $ano, $carrier)`** (privado)
   - Calcula apenas custos variáveis (acima da franquia)
   - Suporta 2 modos:
     - **Franquia compartilhada**: Soma tudo (fixo+móvel) e deduz franquia nacional
     - **Franquia separada**: Deduz franquias de fixo e móvel separadamente
   - Sempre adiciona custo internacional (sem franquia)

3. **`detalharCustos($carrierId, $mes, $ano, $carrier)`** (privado)
   - Retorna breakdown completo de custos por categoria
   - Calcula custo por DID ativo
   - Retorna minutos e custos por tipo (Fixo, Móvel, Internacional)

4. **`ratearCustoFixoPorCliente($carrierId, $mes, $ano)`**
   - Rateia custos entre clientes baseado em quantidade de DIDs
   - Fórmula: `(Valor Plano / DIDs Ativos) × Quantidade de DIDs do Cliente`
   - Retorna: `customer_id`, `quantidade_dids`, `minutos`, `custo_fixo_rateado`, `custo_variavel`, `custo_total`

5. **`ratearCustoPorDid($carrierId, $mes, $ano)`**
   - Rateia custos por DID individual
   - Calcula:
     - **Custo contratado por DID**: `Valor Plano / DIDs Inclusos`
     - **Custo real por DID ativo**: `Valor Plano / DIDs Ativos`
     - **Custo ociosos**: Rateio dos DIDs não utilizados
     - **Custo variável excedente**: Proporção do excedente de franquia
   - Retorna array detalhado por DID

6. **`persistirResumoMensal($mes, $ano, $carrierId)`**
   - Persiste resumo na tabela `carrier_usages`
   - Agrupa por `carrier_id` + `tipo_servico`
   - Valida parâmetros (mês 1-12, ano 2000-2100)
   - **Recém-adicionado** na consolidação do CarrierUsageService

## 📊 Uso no Sistema

### 1. **Dashboard Financeiro** (`app/Livewire/Dashboard/Financial.php`)

**Frequência**: Alto (página mais acessada)

**Uso**:
```php
// Lines 110-126: Calcula custos de TODAS operadoras ativas
$carriers = Carrier::where('ativo', true)->get();
foreach ($carriers as $carrier) {
    $custoCarrier = $costService->calcularCustoReal($carrier->id, $this->mes, $this->ano);
    $custo += $custoCarrier['custo_total'];
    $custosDetalhados[$carrier->id] = $custoCarrier;
}
```

**Problema Identificado**: ❌ **N+1 Problem Severo**
- Loop com chamadas individuais para cada carrier
- Cada `calcularCustoReal()` faz múltiplas queries ao banco
- Executado 2x (mês atual + mês anterior para comparação)
- Executado 6x na evolução de 6 meses
- **Total**: Se houver 5 carriers = 5 × 8 × 4 queries = **160 queries** só para custos!

### 2. **Página de Alocação de Custos** (`app/Livewire/Carriers/CostAllocation.php`)

**Frequência**: Média (relatório administrativo)

**Uso**:
```php
// Lines 78-91: Calcula custo atual + mês anterior
$custoReal = $costService->calcularCustoReal($this->carrier_id, $this->mes, $this->ano);
$custoRealAnterior = $costService->calcularCustoReal($this->carrier_id, $mesAnterior, $anoAnterior);

// Lines 109-110: Rateio por cliente
$alocacoes = $costService->ratearCustoFixoPorCliente($this->carrier_id, $this->mes, $this->ano);

// Lines 149: Rateio por DID
$alocacoes = $costService->ratearCustoPorDid($this->carrier_id, $this->mes, $this->ano);
```

**Problema Identificado**: ⚠️ **Duplicação de Queries**
- `calcularCustoReal()` é chamado 2x (mês atual + anterior)
- `ratearCustoFixoPorCliente()` internamente chama `ratearCustoPorDid()` (line 160)
- `ratearCustoPorDid()` refaz queries já feitas em `calcularCustoReal()`
- Resultado: Mesmas queries executadas 3-4x

### 3. **Página de Manutenção** (`app/Livewire/Maintenance/Index.php`)

**Frequência**: Baixa (uso administrativo)

**Uso**:
```php
// Métodos: gerarRelatoriosOperadora(), processarRelatoriosMesAnterior()
$service = new CarrierCostAllocationService();
$total = $service->persistirResumoMensal($mes, $ano);
```

**Status**: ✅ OK (uso pontual, não crítico)

## 🔍 Problemas Identificados

### 1. ❌ **N+1 Query Problem no Dashboard**

**Localização**: `Financial.php` lines 110-126, 179-184

**Problema**:
```php
foreach ($carriers as $carrier) {
    $custoCarrier = $costService->calcularCustoReal($carrier->id, $this->mes, $this->ano);
    // Cada iteração faz 4-5 queries:
    // 1. Carrier::find()
    // 2. SUM(valor_compra) WHERE tarifa = 'Fixo'
    // 3. SUM(valor_compra) WHERE tarifa = 'Movel'
    // 4. SUM(valor_compra) WHERE tarifa = 'Internacional'
    // 5. SUM(tempo_cobrado), SUM(valor_compra) GROUP BY tarifa
}
```

**Impacto**:
- Dashboard Financeiro: **160+ queries** por renderização
- Cache de 10 minutos alivia, mas primeira renderização é **MUITO LENTA**
- Evolução de 6 meses: **240+ queries** adicionais

### 2. ⚠️ **Queries Duplicadas dentro do Service**

**Localização**: `CarrierCostAllocationService.php`

**Problema**:
```php
// calcularCustoVariavel() - Lines 50-54
$custoTotal = Cdr::where('carrier_id', $carrierId)
    ->whereMonth('calldate', $mes)
    ->whereYear('calldate', $ano)
    ->where('status', 'Tarifada')
    ->sum('valor_compra');

// calcularCustoVariavel() - Lines 65-70
$custoFixo = Cdr::where('carrier_id', $carrierId)
    ->whereMonth('calldate', $mes)
    ->whereYear('calldate', $ano)
    ->where('status', 'Tarifada')
    ->where('tarifa', 'Fixo')
    ->sum('valor_compra');

// calcularCustoVariavel() - Lines 75-80
$custoMovel = Cdr::where('carrier_id', $carrierId)
    ->whereMonth('calldate', $mes)
    ->whereYear('calldate', $ano)
    ->where('status', 'Tarifada')
    ->where('tarifa', 'Movel')
    ->sum('valor_compra');

// detalharCustos() - Lines 104-111
$minutosPorTipo = Cdr::where('carrier_id', $carrierId)
    ->whereMonth('calldate', $mes)
    ->whereYear('calldate', $ano)
    ->where('status', 'Tarifada')
    ->selectRaw('tarifa, SUM(tempo_cobrado) as total_minutos, SUM(valor_compra) as custo')
    ->groupBy('tarifa')
    ->get();
```

**Impacto**:
- Mesmo período consultado 4-5x com filtros levemente diferentes
- Poderia ser 1 query com GROUP BY

### 3. ⚠️ **Carrier::find() Repetido**

**Localização**: Múltiplas

**Problema**:
```php
// Line 16
$carrier = Carrier::find($carrierId);

// Line 148 (ratearCustoFixoPorCliente)
$carrier = Carrier::find($carrierId);

// Line 237 (persistirResumoMensal)
$carrier = Carrier::find($carrierId);

// Line 270 (ratearCustoPorDid)
$carrier = Carrier::find($carrierId);
```

**Impacto**:
- Mesma operadora consultada 2-4x por requisição
- Não usa cache ou reutiliza instância

### 4. ⚠️ **Queries Separadas em `ratearCustoPorDid()`**

**Localização**: Lines 296-317

**Problema**:
```php
// Line 296: Primeiro calcula total
$custoTotalChamadas = Cdr::where('carrier_id', $carrierId)
    ->whereMonth('calldate', $mes)
    ->whereYear('calldate', $ano)
    ->where('status', 'Tarifada')
    ->sum('valor_compra');

// Line 310: Depois agrupa por DID
$usoPorDid = Cdr::where('carrier_id', $carrierId)
    ->whereMonth('calldate', $mes)
    ->whereYear('calldate', $ano)
    ->where('status', 'Tarifada')
    ->selectRaw('did_id, SUM(tempo_cobrado) as total_minutos, SUM(valor_compra) as custo')
    ->groupBy('did_id')
    ->get();
```

**Impacto**:
- Poderia ser 1 query com `SUM() OVER()` ou calcular total no PHP
- Mesmo filtro aplicado 2x

### 5. ⚠️ **Queries em `ratearCustoFixoPorCliente()`**

**Localização**: Lines 160, 271-274

**Problema**:
```php
// Line 160: Chama ratearCustoPorDid() que faz todas as queries
$custosDidDetalhados = $this->ratearCustoPorDid($carrierId, $mes, $ano);

// Line 271: Mas ratearCustoPorDid() também faz eager loading
$didsAtivos = Did::with('customer:id,nomefantasia,razaosocial')
    ->where('carrier_id', $carrierId)
    ->where('ativo', true)
    ->get();
```

**Impacto**:
- DIDs carregados com eager loading, mas depois agrupados manualmente
- Poderia otimizar com DB query direto

## ✅ Pontos Fortes

1. **Lógica de Negócio Correta**
   - Cálculos de franquia compartilhada/separada funcionam perfeitamente
   - Rateio proporcional bem implementado
   - DIDs ociosos corretamente alocados

2. **Validações Adequadas**
   - `persistirResumoMensal()` valida mês e ano
   - Retorna arrays vazios quando não há dados
   - Trata edge cases (divisão por zero)

3. **Código Legível**
   - Comentários explicativos
   - Nomes de variáveis claros
   - Métodos bem separados

4. **Flexibilidade**
   - Suporta franquia compartilhada e separada
   - Aceita carrier específico ou todos
   - Retorna dados estruturados

## 🚀 Oportunidades de Otimização

### 1. **Consolidar Queries em `calcularCustoReal()`** ⭐⭐⭐

**Impacto**: ALTO

**Antes**:
```php
// 4 queries separadas
$custoTotal = Cdr::...->sum('valor_compra');
$custoFixo = Cdr::...->where('tarifa', 'Fixo')->sum('valor_compra');
$custoMovel = Cdr::...->where('tarifa', 'Movel')->sum('valor_compra');
$minutosPorTipo = Cdr::...->groupBy('tarifa')->get();
```

**Depois**:
```php
// 1 query com GROUP BY
$stats = Cdr::where('carrier_id', $carrierId)
    ->whereMonth('calldate', $mes)
    ->whereYear('calldate', $ano)
    ->where('status', 'Tarifada')
    ->selectRaw("
        tarifa,
        SUM(tempo_cobrado) as total_minutos,
        SUM(valor_compra) as total_custo
    ")
    ->groupBy('tarifa')
    ->get()
    ->keyBy('tarifa');
```

**Ganho**: 4-5 queries → 1 query

### 2. **Batch Processing no Dashboard** ⭐⭐⭐

**Impacto**: CRÍTICO

**Solução**: Criar método `calcularCustoRealMultiplos($carrierIds, $mes, $ano)`

```php
public function calcularCustoRealMultiplos(array $carrierIds, $mes, $ano)
{
    // 1 query para todos carriers
    $stats = Cdr::whereIn('carrier_id', $carrierIds)
        ->whereMonth('calldate', $mes)
        ->whereYear('calldate', $ano)
        ->where('status', 'Tarifada')
        ->selectRaw("
            carrier_id,
            tarifa,
            SUM(tempo_cobrado) as total_minutos,
            SUM(valor_compra) as total_custo
        ")
        ->groupBy('carrier_id', 'tarifa')
        ->get()
        ->groupBy('carrier_id');

    // Processar resultados em memória
    // ...
}
```

**Ganho**: 160 queries → 7 queries

### 3. **Cache de Carrier Model** ⭐⭐

**Impacto**: MÉDIO

**Solução**: Passar $carrier como parâmetro ou usar cache interno

```php
private $carrierCache = [];

private function getCarrier($carrierId)
{
    if (!isset($this->carrierCache[$carrierId])) {
        $this->carrierCache[$carrierId] = Carrier::find($carrierId);
    }
    return $this->carrierCache[$carrierId];
}
```

**Ganho**: 4 queries → 1 query por carrier

### 4. **Otimizar `ratearCustoPorDid()`** ⭐⭐

**Impacto**: MÉDIO

**Solução**: Calcular total no PHP em vez de query separada

```php
// Remover line 296-300
// Calcular após $usoPorDid
$custoTotalChamadas = $usoPorDid->sum('custo');
```

**Ganho**: 2 queries → 1 query

### 5. **Índices no Banco** ⭐⭐⭐

**Impacto**: CRÍTICO

**Problema**: Query `WHERE carrier_id AND MONTH(calldate) AND YEAR(calldate)` é lenta

**Solução**: Adicionar índice composto

```php
// Migration
$table->index(['carrier_id', 'calldate', 'status', 'tarifa'], 'idx_cdrs_carrier_period');
```

**Ganho**: Queries 10-100x mais rápidas

## 📈 Estimativa de Impacto

### Dashboard Financeiro (5 carriers, 6 meses de evolução):

**Antes**:
- Queries: ~240
- Tempo: ~5-10 segundos (primeira renderização)
- Cache: 10 minutos

**Depois** (com todas otimizações):
- Queries: ~15
- Tempo: ~0.5-1 segundo
- Cache: 10 minutos (continua)

**Melhoria**: 94% menos queries, 90% mais rápido

### Página de Alocação (1 carrier):

**Antes**:
- Queries: ~20
- Tempo: ~1-2 segundos

**Depois**:
- Queries: ~5
- Tempo: ~0.3-0.5 segundos

**Melhoria**: 75% menos queries, 70% mais rápido

## 🎓 Conclusão

O **CarrierCostAllocationService** é um service **bem arquitetado com lógica correta**, mas sofre de **problemas de performance** devido a:

1. **N+1 queries** no Dashboard
2. **Queries duplicadas** dentro dos métodos
3. **Falta de batch processing** para múltiplos carriers
4. **Ausência de índices otimizados** no banco

**Recomendação**: Implementar otimizações de queries mantendo a lógica de negócio intacta.

---

**Próximos Passos**:
1. ✅ Criar método `calcularCustoRealMultiplos()` para batch processing
2. ✅ Consolidar queries em métodos individuais
3. ✅ Adicionar cache de Carrier models
4. ✅ Criar índices otimizados
5. ✅ Migrar Dashboard e CostAllocation para usar novos métodos
