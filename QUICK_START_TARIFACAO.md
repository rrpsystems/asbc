# Quick Start - Tarifação em Lote

## 🚀 Para Produção (Recomendado)

### Processamento Assíncrono com Queue

```bash
# 1. Despachar jobs de lote (retorna imediatamente)
php artisan tariff:dispatch-batches --batch-size=5000

# 2. Iniciar workers para processar (em terminais separados)
php artisan queue:work --verbose --timeout=600 --name=worker-1
php artisan queue:work --verbose --timeout=600 --name=worker-2
php artisan queue:work --verbose --timeout=600 --name=worker-3

# 3. Monitorar progresso
tail -f storage/logs/laravel.log
```

**Vantagens:**
- ✅ Não trava o terminal
- ✅ Múltiplos workers processam em paralelo
- ✅ ~200k CDRs em 1-2 horas (com 3 workers)
- ✅ Retry automático se um lote falhar

---

## 🧪 Para Testes e Desenvolvimento

### Processamento Síncrono Direto

```bash
# Processa até 5000 CDRs com progresso em tempo real
php artisan tariff:process-pending --limit=5000
```

**Vantagens:**
- ✅ Simples e direto
- ✅ Progress bar em tempo real
- ✅ Não precisa de workers
- ✅ Ideal para testes

---

## 📋 Comandos Úteis

### Verificar CDRs pendentes
```bash
php artisan tinker --execute="echo 'Pendentes: ' . \App\Models\Cdr::where('status', 'Pendente')->count();"
```

### Resetar CDRs com erro para reprocessar
```bash
php artisan tariff:reset-failed --all --no-interaction
```

### Testar tarifação de um CDR específico
```bash
php artisan tariff:test 12345
```

### Ver jobs falhados
```bash
php artisan queue:failed
```

### Monitorar fila
```bash
php artisan queue:monitor
```

---

## 🎯 Recomendações por Volume

| CDRs | Comando Recomendado | Workers | Tempo Estimado |
|------|---------------------|---------|----------------|
| < 5k | `tariff:process-pending` | 0 | 5-10 min |
| 5k-50k | `tariff:process-pending` | 0 | 30 min - 1h |
| 50k-200k | `tariff:dispatch-batches` | 3 | 1-2 horas |
| > 200k | `tariff:dispatch-batches` | 5+ | Variável |

---

## 📊 Exemplo Completo: 200k CDRs

```bash
# 1. Despachar 40 jobs de 5000 CDRs cada
php artisan tariff:dispatch-batches --batch-size=5000

# Output:
# 📦 Total de lotes a criar: 40
# ✅ JOBS DESPACHADOS: 40

# 2. Iniciar 3 workers (Windows - PowerShell)
Start-Process php -ArgumentList "artisan","queue:work","--timeout=600"
Start-Process php -ArgumentList "artisan","queue:work","--timeout=600"
Start-Process php -ArgumentList "artisan","queue:work","--timeout=600"

# 3. Acompanhar logs
tail -f storage/logs/laravel.log

# Cada lote processado gera log:
# [info] Lote de CDRs processado com sucesso
# cdrs_processados: 5000
# sucesso: 4998
# erros: 2
# taxa_sucesso: 99.96%
# duracao_segundos: 312.45
# velocidade_cdrs_s: 16
```

---

## ⚠️ Troubleshooting

### Workers não processando jobs

**Verificar se há jobs na fila:**
```bash
php artisan queue:monitor
```

**Restart workers:**
```bash
# Matar todos os processos PHP
taskkill /F /IM php.exe

# Reiniciar workers
php artisan queue:work --verbose
```

### CDRs com status "Tarifa_Nao_Encontrada"

**Significa que não existe rate cadastrada para aquele carrier/tarifa/prefixo**

1. Identificar quais rates estão faltando nos logs
2. Cadastrar em `/config/rate`
3. Reprocessar:
```bash
php artisan tariff:reset-failed --status=Tarifa_Nao_Encontrada --no-interaction
php artisan tariff:dispatch-batches --batch-size=5000
```

---

## 📖 Documentação Completa

Ver arquivo: `TARIFACAO_BATCH.md`
