# Fase 4: Painel de Revenda - Implementação Completa

## Visão Geral

Sistema completo de autogestão para revendas, permitindo que gerenciem seus próprios markups, visualizem clientes e analisem comissões.

## Componentes Implementados

### 1. Dashboard de Revenda
**Arquivo:** `app/Livewire/Resellers/Dashboard.php`

**Funcionalidades:**
- Resumo financeiro do mês atual
- Navegação entre meses (anterior/próximo)
- Estatísticas em tempo real:
  - Total de clientes (ativos e inativos)
  - Valor a pagar ao provider (base)
  - Valor a receber dos clientes (com markup)
  - Lucro total e margem percentual
- Detalhamento por tipo de serviço:
  - Chamadas (quantidade, minutos, valores)
  - Produtos e serviços
- Top 5 clientes do mês por faturamento

**Rota:** `/reseller/dashboard`

**Métricas calculadas:**
```php
// Chamadas
- Total de chamadas
- Total de minutos
- Receita base (SUM(valor_venda))
- Receita final (SUM(valor_venda_final))
- Lucro (receita_final - receita_base)

// Produtos
- Custo base
- Receita final (aplicando markup configurado)
- Lucro

// Total
- Custo base total
- Receita final total
- Lucro total
- Margem percentual
```

### 2. Configurações de Markup
**Arquivo:** `app/Livewire/Resellers/Settings.php`

**Funcionalidades:**
- Configuração autônoma de markups pela revenda
- Dois modos de precificação:
  1. **Percentual** - markup sobre valor base
  2. **Valor Fixo** - preço absoluto (sobrescreve percentual)
- Categorias configuráveis:
  - Chamadas
  - Produtos
  - Planos
  - DIDs
- Preview em tempo real do cálculo
- Validação de valores (0-1000%)

**Rota:** `/reseller/settings`

**Regras de negócio:**
- Se `valor_fixo_*` está preenchido, ignora `markup_*`
- Alterações afetam apenas novas chamadas/faturas
- Valores já processados não são recalculados

**Exemplo de cálculo no formulário:**
```
Markup Chamadas: 50%
Exemplo: R$ 0,10 → R$ 0,15
(0.10 * 1.50 = 0.15)
```

### 3. Lista de Clientes
**Arquivo:** `app/Livewire/Resellers/Customers.php`

**Funcionalidades:**
- Visualização filtrada (apenas clientes da revenda)
- Busca por razão social, CNPJ, email
- Filtro por status (todos/ativos/inativos)
- Ordenação por múltiplas colunas
- Paginação configurável
- Estatísticas resumidas:
  - Total de clientes
  - Clientes ativos
  - Clientes inativos

**Rota:** `/reseller/customers`

**Campos exibidos:**
- Contrato (ID)
- Razão Social / Nome Fantasia
- CNPJ (formatado)
- Email
- Telefone
- Status (Ativo/Inativo/Bloqueado)

**Escopo de dados:**
```php
Customer::where('reseller_id', $this->reseller->id)
```

### 4. Relatórios de Comissão
**Arquivo:** `app/Livewire/Resellers/Reports.php`

**Funcionalidades:**
- Navegação entre meses
- 3 tipos de visualização:

#### 4.1. Resumo Geral
Cards visuais com:
- **Chamadas:** total, minutos, custos, receitas, lucro
- **Produtos:** custo base, receita final, lucro
- **Total do Mês:** valores consolidados e margem

#### 4.2. Por Cliente
Tabela detalhada com:
- Nome do cliente e ID
- Quantidade de chamadas
- Total de minutos
- Custo base (a pagar)
- Receita final (a receber)
- Lucro
- Margem percentual
- Ordenação por receita (maior → menor)

#### 4.3. Por Data
Relatório diário com:
- Data e dia da semana
- Total de chamadas
- Minutos
- Custo base
- Receita final
- Lucro

**Rota:** `/reseller/reports`

**SQL de exemplo (resumo):**
```sql
-- Chamadas do mês
SELECT
    COUNT(*) as total_chamadas,
    SUM(cdrs.billsec) as total_segundos,
    SUM(cdrs.valor_venda) as custo_base,
    SUM(COALESCE(cdrs.valor_venda_final, cdrs.valor_venda)) as receita_final,
    SUM(COALESCE(cdrs.valor_markup, 0)) as lucro
FROM cdrs
JOIN customers ON cdrs.customer_id = customers.id
WHERE customers.reseller_id = ?
  AND cdrs.start BETWEEN ? AND ?
  AND cdrs.cobrada = true
```

## Rotas Configuradas

**Arquivo:** `routes/web.php`

```php
Route::prefix('reseller')->name('reseller.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Resellers\Dashboard::class)->name('dashboard');
    Route::get('/settings', \App\Livewire\Resellers\Settings::class)->name('settings');
    Route::get('/customers', \App\Livewire\Resellers\Customers::class)->name('customers');
    Route::get('/reports', \App\Livewire\Resellers\Reports::class)->name('reports');
});
```

## Menu Lateral Adaptativo

**Arquivo:** `resources/views/livewire/template/sidebar.blade.php`

### Menu para RESELLER
Visível apenas quando `Auth::user()->rule === UserRole::RESELLER`:
- Dashboard
- Meus Clientes
- Relatórios
- Configurações

### Menu para ADMIN/MANAGER
Menu completo padrão:
- Dashboard
- Financeiro
- Alertas
- Manutenção
- Relatórios (todos)
- Gestão
- Configurações (todos)

**Implementação:**
```blade
@if(Auth::user()->rule === App\Enums\UserRole::RESELLER)
    <!-- Menu reduzido para revenda -->
@else
    <!-- Menu completo para admin -->
@endif
```

## Permissões e Segurança

### Validação de Acesso
Todos os componentes verificam:
```php
public function mount()
{
    $user = Auth::user();

    if (!$user->reseller_id) {
        abort(403, 'Usuário não está associado a uma revenda');
    }

    $this->reseller = Reseller::findOrFail($user->reseller_id);
}
```

### Escopo de Dados
- **Clientes:** Apenas `customers.reseller_id = user.reseller_id`
- **CDRs:** Apenas de clientes da revenda
- **Revenue:** Apenas de clientes da revenda

### Visibilidade de Valores
**Revenda VÊ:**
- ✅ Valor base (o que deve pagar ao provider)
- ✅ Valor final (o que cobra dos clientes)
- ✅ Lucro (diferença)
- ✅ Seus próprios markups

**Revenda NÃO VÊ:**
- ❌ Valor de compra do provider (custo da operadora)
- ❌ Clientes de outras revendas
- ❌ Configurações administrativas

## Fluxo de Uso

### 1. Primeiro Acesso
1. Usuário tipo RESELLER faz login
2. É redirecionado para `/reseller/dashboard`
3. Vê estatísticas do mês atual

### 2. Configurar Markups
1. Acessa "Configurações"
2. Define markups percentuais ou valores fixos
3. Salva alterações
4. Novas chamadas usarão novos markups

### 3. Visualizar Clientes
1. Acessa "Meus Clientes"
2. Busca/filtra conforme necessário
3. Vê lista completa dos seus clientes

### 4. Analisar Comissões
1. Acessa "Relatórios"
2. Escolhe tipo de visualização:
   - **Resumo Geral** - overview rápido
   - **Por Cliente** - identificar top clientes
   - **Por Data** - análise temporal
3. Navega entre meses
4. Analisa margens e lucros

## Integração com Sistema Existente

### Dados Utilizados
- **Tabela `resellers`** - configurações e markups
- **Tabela `customers`** - filtro por `reseller_id`
- **Tabela `cdrs`** - usa `valor_venda_final` e `valor_markup`
- **Tabela `revenue_summaries`** - produtos e serviços

### Cálculos em Tempo Real
Produtos aplicam markup dinamicamente:
```php
if ($this->reseller->valor_fixo_produtos) {
    $receita_final = $this->reseller->valor_fixo_produtos * $total_clientes;
} else {
    $receita_final = $receita_base * (1 + $this->reseller->markup_produtos / 100);
}
```

## Validações Implementadas

### Settings (Markups)
```php
[
    'markup_chamadas' => 'required|numeric|min:0|max:1000',
    'markup_produtos' => 'required|numeric|min:0|max:1000',
    'markup_planos' => 'required|numeric|min:0|max:1000',
    'markup_dids' => 'required|numeric|min:0|max:1000',
    'valor_fixo_chamadas' => 'nullable|numeric|min:0',
    'valor_fixo_produtos' => 'nullable|numeric|min:0',
    'valor_fixo_planos' => 'nullable|numeric|min:0',
    'valor_fixo_dids' => 'nullable|numeric|min:0',
]
```

## Exemplos de Uso

### Cenário 1: Revenda com Markup de 30%
```
Configuração:
- markup_chamadas = 30%
- valor_fixo_chamadas = NULL

CDR processado:
- valor_venda = R$ 0,10 (base)
- valor_venda_final = R$ 0,13 (0.10 * 1.30)
- valor_markup = R$ 0,03

Dashboard mostra:
- A Pagar: R$ 0,10
- A Receber: R$ 0,13
- Lucro: R$ 0,03
- Margem: 30%
```

### Cenário 2: Revenda com Valor Fixo
```
Configuração:
- markup_produtos = 50% (ignorado)
- valor_fixo_produtos = R$ 80,00

Produto base: R$ 50,00

Cálculo:
- Custo base = R$ 50,00
- Receita final = R$ 80,00 (fixo)
- Lucro = R$ 30,00
- Margem = 60%
```

## Componentes de UI

### Cards de Estatísticas
- Gradientes coloridos
- Ícones SVG descritivos
- Valores formatados (R$ e %)
- Métricas secundárias

### Tabelas
- Responsivas (overflow-x-auto)
- Hover states
- Ordenação interativa
- Paginação integrada
- Empty states

### Formulários
- Labels descritivos
- Validação em tempo real
- Preview de cálculos
- Alertas informativos

## Performance

### Otimizações
- Eager loading de relacionamentos
- Queries agregadas (SUM, COUNT)
- Uso de índices (customer_id, reseller_id)
- Paginação para grandes volumes

### Exemplo de Query Otimizada
```php
// Evita N+1 queries
$customers = Customer::where('reseller_id', $this->reseller->id)
    ->with('reseller')  // se necessário
    ->orderBy($this->sort, $this->direction)
    ->paginate($this->perPage);
```

## Próximos Passos Opcionais

### Fase 5 (Futura)
- Exportação de relatórios (PDF/Excel)
- Gráficos visuais (Chart.js)
- Notificações por email
- API REST para integrações

### Melhorias de UX
- Filtros avançados nos relatórios
- Comparação entre períodos
- Metas e KPIs
- Dashboard personalizável

## Arquivos Criados

```
app/Livewire/Resellers/
├── Dashboard.php          # Dashboard principal
├── Settings.php          # Configuração de markups
├── Customers.php         # Lista de clientes
└── Reports.php           # Relatórios de comissão

resources/views/livewire/resellers/
├── dashboard.blade.php
├── settings.blade.php
├── customers.blade.php
└── reports.blade.php
```

## Arquivos Modificados

```
routes/web.php                              # Rotas reseller.*
resources/views/livewire/template/sidebar.blade.php  # Menu adaptativo
```

## Testes Recomendados

### 1. Teste de Permissões
- [ ] Usuário RESELLER acessa apenas suas rotas
- [ ] Usuário RESELLER não vê dados de outras revendas
- [ ] Usuário sem reseller_id recebe 403

### 2. Teste de Cálculos
- [ ] Markup percentual aplica corretamente
- [ ] Valor fixo sobrescreve markup
- [ ] Margem percentual calcula corretamente
- [ ] Produtos aplicam markup em tempo real

### 3. Teste de UI
- [ ] Menu muda conforme tipo de usuário
- [ ] Navegação entre meses funciona
- [ ] Filtros e buscas retornam resultados corretos
- [ ] Paginação funciona

### 4. Teste de Edge Cases
- [ ] Revenda sem clientes
- [ ] Mês sem chamadas
- [ ] Valores zerados
- [ ] Cliente inativo

## Conclusão

A Fase 4 implementa um sistema completo e autônomo para revendas gerenciarem seus negócios, incluindo:

✅ Dashboard com métricas em tempo real
✅ Autogestão de markups
✅ Visualização de clientes
✅ Relatórios detalhados de comissão
✅ Menu adaptativo por tipo de usuário
✅ Permissões e segurança
✅ Interface responsiva e profissional

O sistema está pronto para uso após executar a migração da Fase 3 que adiciona os campos `valor_venda_final` e `valor_markup` à tabela `cdrs`.
