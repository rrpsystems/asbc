# Diagnóstico: Fechar e Reabrir Faturas

## Problema Relatado
Ao clicar nos botões "Fechar Faturamento" e "Reabrir Faturamento", nada acontece e as faturas continuam abertas.

## Possíveis Causas

### 1. Não há faturas para fechar (preview retorna 0)

Execute no navegador/browser console (F12):
```
javascript
Livewire.all()[0].$wire.fecharFaturasPreview
```

Ou execute via PHP:
```bash
php artisan tinker
```

Depois execute:
```php
// Verifica quantas faturas existem no mês anterior (padrão do modal)
$mesAnterior = now()->subMonth();
$mes = $mesAnterior->month;
$ano = $mesAnterior->year;

echo "Mês/Ano: {$mes}/{$ano}\n";

$faturasAbertas = \App\Models\RevenueSummary::where('mes', $mes)
    ->where('ano', $ano)
    ->where('fechado', false)
    ->count();

$faturasTotal = \App\Models\RevenueSummary::where('mes', $mes)
    ->where('ano', $ano)
    ->count();

echo "Faturas abertas: {$faturasAbertas}\n";
echo "Faturas total: {$faturasTotal}\n";

$relatoriosAbertos = \App\Models\CarrierUsage::where('mes', $mes)
    ->where('ano', $ano)
    ->where('fechado', false)
    ->count();

$relatoriosTotal = \App\Models\CarrierUsage::where('mes', $mes)
    ->where('ano', $ano)
    ->count();

echo "Relatórios abertos: {$relatoriosAbertos}\n";
echo "Relatórios total: {$relatoriosTotal}\n";
```

### 2. Erros JavaScript/Livewire

Abra o console do navegador (F12 → Console) e verifique se há erros quando clicar no botão.

### 3. Criar Dados de Teste

Se não houver faturas, crie dados de teste:

```bash
php artisan tinker
```

```php
// Cria fatura de teste para o mês anterior
$mesAnterior = now()->subMonth();
$customer = \App\Models\Customer::first();

if ($customer) {
    \App\Models\RevenueSummary::create([
        'customer_id' => $customer->id,
        'mes' => $mesAnterior->month,
        'ano' => $mesAnterior->year,
        'franquia_minutos' => 3000,
        'minutos_usados' => 1500,
        'minutos_excedentes' => 0,
        'valor_plano' => 100.00,
        'custo_excedente' => 0,
        'custo_total' => 100.00,
        'fechado' => false,  // IMPORTANTE: criar como aberto
    ]);

    echo "Fatura de teste criada!\n";
} else {
    echo "Nenhum cliente encontrado!\n";
}
```

### 4. Testar Fechamento Manual

```bash
php artisan tinker
```

```php
// Fecha manualmente para testar
$mesAnterior = now()->subMonth();

$result = \App\Models\RevenueSummary::where('mes', $mesAnterior->month)
    ->where('ano', $mesAnterior->year)
    ->where('fechado', false)
    ->update(['fechado' => true]);

echo "Faturas fechadas: {$result}\n";

// Verifica se funcionou
$abertas = \App\Models\RevenueSummary::where('mes', $mesAnterior->month)
    ->where('ano', $mesAnterior->year)
    ->where('fechado', false)
    ->count();

echo "Faturas ainda abertas: {$abertas}\n";
```

### 5. Verificar Logs

```bash
tail -f storage/logs/laravel.log | grep "Fechamento de faturas"
```

Depois clique no botão "Fechar Faturamento" e veja se aparece algum log.

### 6. Verificar se Modal Abre

- Clique em "Fechar Faturamento"
- Modal deve abrir mostrando seletores de mês/ano
- Verifique se o **preview** aparece (mostra quantas faturas)
- Se preview mostrar "0" faturas, o botão "Fechar Faturamento" estará desabilitado (cinza)

### 7. Verificar Network (Requisições Livewire)

1. Abra DevTools (F12)
2. Vá em **Network**
3. Filtre por "livewire"
4. Clique em "Fechar Faturamento"
5. Veja se aparece uma requisição POST para `/livewire/update`
6. Verifique a resposta

## Solução Mais Provável

**O problema é que não há faturas para fechar no mês anterior!**

Se o preview mostrar:
```
Faturas de Clientes: 0
Relatórios de Operadoras: 0
```

O botão ficará desabilitado (cinza) e não fará nada ao clicar.

**Soluções:**

1. **Crie faturas de teste** (ver código acima)
2. **Mude o mês/ano no modal** para um período que tenha faturas
3. **Ou gere faturas primeiro** executando o processamento de receitas

## Teste Completo Passo a Passo

```bash
# 1. Verificar dados existentes
php artisan tinker --execute="
echo 'Resumos de receita:\n';
\$total = \App\Models\RevenueSummary::count();
echo 'Total: ' . \$total . '\n';
\$abertas = \App\Models\RevenueSummary::where('fechado', false)->count();
echo 'Abertas: ' . \$abertas . '\n';
"

# 2. Se não houver, criar dados de teste
php artisan tinker --execute="
\$customer = \App\Models\Customer::first();
if (\$customer) {
    \$mesAnterior = now()->subMonth();
    \App\Models\RevenueSummary::create([
        'customer_id' => \$customer->id,
        'mes' => \$mesAnterior->month,
        'ano' => \$mesAnterior->year,
        'franquia_minutos' => 3000,
        'minutos_usados' => 1500,
        'minutos_excedentes' => 0,
        'valor_plano' => 100.00,
        'custo_excedente' => 0,
        'custo_total' => 100.00,
        'fechado' => false,
    ]);
    echo 'Fatura criada: ' . \$mesAnterior->month . '/' . \$mesAnterior->year . '\n';
}
"

# 3. Agora tente na interface web:
# - Acesse /maintenance
# - Clique em "Fechar Faturamento"
# - Modal deve abrir mostrando "Faturas de Clientes: 1"
# - Botão "Fechar Faturamento" deve estar verde (habilitado)
# - Clique no botão
# - Deve aparecer toast: "✅ Faturamento fechado!"

# 4. Verificar se fechou
php artisan tinker --execute="
\$mesAnterior = now()->subMonth();
\$abertas = \App\Models\RevenueSummary::where('mes', \$mesAnterior->month)
    ->where('ano', \$mesAnterior->year)
    ->where('fechado', false)
    ->count();
echo 'Faturas abertas: ' . \$abertas . '\n';

\$fechadas = \App\Models\RevenueSummary::where('mes', \$mesAnterior->month)
    ->where('ano', \$mesAnterior->year)
    ->where('fechado', true)
    ->count();
echo 'Faturas fechadas: ' . \$fechadas . '\n';
"
```

## Se Ainda Não Funcionar

Envie os seguintes dados:

1. **Output do teste acima** (quantas faturas abertas/fechadas)
2. **Console do navegador** (F12 → Console) - erros JavaScript
3. **Network** (F12 → Network → livewire) - requisições ao clicar
4. **Log do Laravel** (`tail -f storage/logs/laravel.log`)

Isso me ajudará a identificar o problema exato!
