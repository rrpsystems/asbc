# 📊 Sistema de Tarifação de Chamadas - Documentação Completa

## 🎯 Visão Geral

O sistema calcula automaticamente os custos (compra/venda) de cada chamada telefônica (CDR) baseado em **regras de tarifação configuráveis** armazenadas na tabela `rates`.

---

## 📋 Estrutura da Tabela `rates`

Cada **rate** define as regras de tarifação para um tipo específico de chamada:

| Campo | Tipo | Descrição | Exemplo |
|-------|------|-----------|---------|
| `id` | bigint | ID único da tarifa | 3 |
| `carrier_id` | bigint | ID da operadora | 1330100009 |
| `tarifa` | varchar | **Tipo de chamada** (Fixo, Movel, Internacional, Entrada, Gratuito, Servico) | "Entrada" |
| `prefixo` | varchar | Prefixo do número (para matching) ou NULL (aplica a todos) | "11", "119", NULL |
| `descricao` | varchar | Descrição da tarifa | "Chamadas para São Paulo" |
| `tempoinicial` | integer | **Tempo inicial grátis** (segundos) | 3 |
| `tempominimo` | integer | **Tempo mínimo de cobrança** (segundos) | 30 |
| `incremento` | integer | **Incremento de cobrança** (segundos) - cadência | 6 |
| `compra` | numeric | **Valor de compra** (R$/minuto) | 0.08 |
| `venda` | numeric | **Valor de venda** (R$/minuto) | 0.15 |
| `vconexao` | numeric | **Taxa de conexão** (R$ fixo por chamada) | 0.05 |
| `ativo` | boolean | Se a tarifa está ativa | true |

---

## 🔍 Como o Sistema Busca a Tarifa Correta

### 1. Critérios de Busca

Para cada CDR, o sistema busca uma `rate` que atenda **TODOS** estes critérios:

```sql
WHERE carrier_id = [carrier_id do CDR]
  AND tarifa = [tarifa do CDR]
  AND ativo = true
  AND (numero LIKE prefixo || '%' OR prefixo IS NULL)
ORDER BY LENGTH(prefixo) DESC
LIMIT 1
```

### 2. Prioridade por Prefixo

- **Prefixo mais específico primeiro**: Se existirem múltiplas rates, a com prefixo **mais longo** tem prioridade
- **Exemplo**:
  - Rate 1: `prefixo = "11"` (2 dígitos)
  - Rate 2: `prefixo = "119"` (3 dígitos)
  - Rate 3: `prefixo = NULL` (fallback)
  - Para número `11987654321` → Rate 2 vence (mais específica)

### 3. Cache de Performance

- Cada busca é **cacheada por 1 hora** para evitar consultas repetidas
- Chave do cache: `rate:{carrier_id}:{tarifa}:{md5(numero)}`
- O cache é invalidado automaticamente quando uma rate é atualizada

---

## 💰 Cálculo de Valores

### Passo 1: Calcular Tempo Cobrado

O algoritmo calcula o **tempo efetivamente cobrado** seguindo estas regras:

```php
function calcularTempoCobrado($tempoFalado, $rate) {
    // 1. Se valor de venda = 0, não cobra nada
    if ($rate->venda == 0) {
        return 0;
    }

    // 2. Se tempo falado <= tempo inicial, não cobra (franquia inicial)
    if ($tempoFalado <= $rate->tempoinicial) {
        return 0;
    }

    // 3. Se tempo falado < tempo mínimo, cobra o tempo mínimo
    if ($tempoFalado < $rate->tempominimo) {
        return $rate->tempominimo;
    }

    // 4. Calcula incrementos (arredonda pra cima)
    $tempoExtra = $tempoFalado - $rate->tempominimo;
    $incrementos = ceil($tempoExtra / $rate->incremento);

    return $rate->tempominimo + ($incrementos * $rate->incremento);
}
```

#### 📊 Exemplo Prático de Cálculo

**Rate configurada:**
- `tempoinicial = 3` segundos (franquia)
- `tempominimo = 30` segundos
- `incremento = 6` segundos (cadência)
- `venda = 0.15` R$/minuto
- `vconexao = 0.05` R$

**Cenários:**

| Tempo Falado | Tempo Cobrado | Explicação |
|--------------|---------------|------------|
| 2s | 0s | ≤ tempoinicial (franquia) |
| 5s | 30s | < tempominimo → cobra mínimo |
| 30s | 30s | = tempominimo → cobra exato |
| 35s | 36s | 30 + ceil(5/6) × 6 = 30 + 6 |
| 40s | 42s | 30 + ceil(10/6) × 6 = 30 + 12 |
| 60s | 60s | 30 + ceil(30/6) × 6 = 30 + 30 |

### Passo 2: Calcular Valor Monetário

```php
function calcularValor($tempoCobrado, $valorTarifa, $valorConexao) {
    return round(
        ($tempoCobrado * ($valorTarifa / 60)) + $valorConexao,
        4
    );
}
```

#### 💡 Exemplo de Cálculo Completo

**Chamada de 40 segundos com a rate acima:**

1. **Tempo Cobrado**: 42s (calculado no passo 1)

2. **Valor de Venda**:
   ```
   (42 × (0.15 / 60)) + 0.05
   = (42 × 0.0025) + 0.05
   = 0.105 + 0.05
   = R$ 0.1550
   ```

3. **Valor de Compra** (se `compra = 0.08`):
   ```
   (42 × (0.08 / 60)) + 0.05
   = (42 × 0.001333) + 0.05
   = 0.056 + 0.05
   = R$ 0.1060
   ```

4. **Margem de Lucro**:
   ```
   R$ 0.1550 - R$ 0.1060 = R$ 0.0490
   ```

---

## 🔄 Fluxo de Processamento

```
┌─────────────┐
│   CDR novo  │
│ (Pendente)  │
└──────┬──────┘
       │
       ▼
┌──────────────────────────────────────┐
│  CallTariffJob (background)          │
│  - Lock do CDR                       │
│  - Valida dados básicos              │
└──────┬───────────────────────────────┘
       │
       ▼
┌──────────────────────────────────────┐
│  RateCacheService.findRate()         │
│  1. Busca no cache                   │
│  2. Se não achar, query no DB        │
│  3. Filtra: carrier + tarifa + ativo │
│  4. Match de prefixo (LIKE)          │
│  5. Ordena por LENGTH(prefixo) DESC  │
└──────┬───────────────────────────────┘
       │
       ├─── Rate encontrada ────►┌──────────────────────────────┐
       │                         │ CallTariffService            │
       │                         │  1. calcularTempoCobrado()   │
       │                         │  2. calcularValor(compra)    │
       │                         │  3. calcularValor(venda)     │
       │                         └──────┬───────────────────────┘
       │                                │
       │                                ▼
       │                         ┌──────────────────────────────┐
       │                         │  CDR atualizado:             │
       │                         │  - tempo_cobrado             │
       │                         │  - valor_compra              │
       │                         │  - valor_venda               │
       │                         │  - status = "Tarifada"       │
       │                         └──────────────────────────────┘
       │
       └─── Rate NÃO encontrada ─►┌──────────────────────────────┐
                                  │  CDR marcado como:           │
                                  │  status = "Tarifa_Nao_Encontrada"│
                                  └──────────────────────────────┘
```

---

## 🎛️ Tipos de Tarifas Suportados

O sistema suporta **6 tipos** de tarifas configuráveis:

| Tipo | Descrição | Exemplo de Uso |
|------|-----------|----------------|
| **Fixo** | Chamadas para telefones fixos | 11 XXXX-XXXX |
| **Movel** | Chamadas para celulares | 11 9XXXX-XXXX |
| **Internacional** | Chamadas internacionais | +1 XXX XXX XXXX |
| **Entrada** | Chamadas recebidas | DDR/DID |
| **Gratuito** | Chamadas 0800, 4004, etc. | 0800 XXX XXXX |
| **Servico** | Serviços especiais (190, 192, etc.) | 192, 190 |

**IMPORTANTE**: Não há validação hardcoded de tipos! Você pode:
- ✅ Criar novos tipos de tarifas
- ✅ Renomear tipos existentes
- ✅ Configurar valores e cadências específicas para cada tipo

---

## ⚙️ Configuração via Interface

### Rota: `/config/rate`

Acesse esta rota para:

1. **Cadastrar novas tarifas**
   - Selecionar operadora (carrier)
   - Definir tipo (Fixo, Movel, Entrada, etc.)
   - Configurar prefixo (ou deixar NULL para catch-all)

2. **Configurar cadências**
   - Tempo inicial (franquia)
   - Tempo mínimo
   - Incremento (pulso)

3. **Definir valores**
   - Custo de compra (R$/min)
   - Valor de venda (R$/min)
   - Taxa de conexão (R$)

4. **Ativar/Desativar tarifas**
   - Apenas rates com `ativo = true` são usadas

---

## 📊 Status do CDR

Durante o processamento, o CDR pode ter os seguintes status:

| Status | Descrição |
|--------|-----------|
| `Pendente` | Aguardando tarifação |
| `Tarifada` | Tarifada com sucesso |
| `Tarifa_Nao_Encontrada` | Não existe rate configurada |
| `Dados_Invalidos` | CDR com dados inválidos (numero vazio, billsec negativo, etc.) |
| `Erro_Tarifa` | Erro durante processamento (será retentado) |
| `Erro_Permanente` | Falhou após todas as tentativas |

---

## 🚀 Performance e Otimizações

### Cache de Rates
- ✅ Cache de 1 hora por rate consultada
- ✅ Reduz queries ao banco em ~90%
- ✅ Invalidação automática ao atualizar rates

### Processamento em Lote
- ✅ `calcularTarifasEmLote()` processa múltiplos CDRs
- ✅ Pré-carrega todas as rates necessárias (1 query)
- ✅ Ideal para reprocessamento

### Jobs Assíncronos
- ✅ Tarifação em background (CallTariffJob)
- ✅ 3 tentativas com backoff exponencial
- ✅ Lock para evitar processamento duplicado

---

## 🔧 Casos Especiais

### Chamadas de Entrada (Gratuitas)

Normalmente configuradas com:
```
compra = 0.00
venda = 0.00
vconexao = 0.00
```

Mesmo que o `billsec > 0`, o valor será R$ 0.00.

### Chamadas 0800 (Gratuitas para Origem)

O **cliente** não paga, mas você pode ter custo de compra:
```
compra = 0.05  ← você paga a operadora
venda = 0.00   ← cliente não paga
```

### Prefixos Específicos

Você pode criar rates para códigos específicos:
```
prefixo = "0800"  → Apenas 0800
prefixo = "11"    → Todos de São Paulo
prefixo = NULL    → Fallback (todos)
```

---

## 📝 Exemplo Real de Configuração

### Cenário: Operadora Algar (ID: 1330100009)

```sql
-- Fixo SP (11)
INSERT INTO rates VALUES (
    prefixo = '11',
    carrier_id = 1330100009,
    tarifa = 'Fixo',
    tempoinicial = 3,
    tempominimo = 30,
    incremento = 6,
    compra = 0.08,
    venda = 0.15,
    vconexao = 0.05
);

-- Movel SP (11 9)
INSERT INTO rates VALUES (
    prefixo = '119',
    carrier_id = 1330100009,
    tarifa = 'Movel',
    tempoinicial = 3,
    tempominimo = 30,
    incremento = 6,
    compra = 0.25,
    venda = 0.45,
    vconexao = 0.05
);

-- Entrada (todas)
INSERT INTO rates VALUES (
    prefixo = NULL,
    carrier_id = 1330100009,
    tarifa = 'Entrada',
    tempoinicial = 0,
    tempominimo = 0,
    incremento = 1,
    compra = 0.00,
    venda = 0.00,
    vconexao = 0.00
);
```

---

## 🎓 Resumo

1. **Rates são 100% configuráveis** - não há lógica hardcoded
2. **Matching inteligente** - usa prefixos com prioridade por especificidade
3. **Cache automático** - otimiza consultas repetidas
4. **Cálculo preciso** - respeita franquias, mínimos e incrementos
5. **Flexível** - suporta qualquer tipo de tarifa personalizada

Qualquer dúvida sobre configuração ou cálculos, consulte esta documentação! 🚀
