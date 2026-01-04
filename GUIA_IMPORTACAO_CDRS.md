# 📚 Guia de Importação de CDRs

**Data**: 2025-12-27
**Comando**: `php artisan cdr:import`

---

## 🎯 Objetivo

Importar CDRs de um banco de dados antigo (via arquivo SQL) para o novo sistema, preservando a integridade dos dados e permitindo reprocessamento completo.

---

## 📋 Pré-requisitos

### 1. Exportar CDRs da Base Antiga

**⭐ RECOMENDADO: Exportar como CSV** (mais rápido e simples):

```bash
# No PostgreSQL da base antiga
psql -h localhost -U seu_usuario -d base_antiga -c "\COPY (SELECT * FROM cdrs WHERE calldate >= '2025-01-01' ORDER BY calldate) TO '/tmp/cdrs_export.csv' WITH CSV HEADER"
```

**Ou usando SQL INSERTs** (mais compatível, mas parsing mais complexo):

No **PostgreSQL da base antiga**, execute:

```sql
-- Exportar TODOS os CDRs
COPY (
    SELECT
        'INSERT INTO public.cdrs (' ||
        'id, calldate, clid, src, dst, dcontext, channel, dstchannel, lastapp, lastdata, ' ||
        'duration, billsec, disposition, amaflags, accountcode, uniqueid, userfield, prefixo, ' ||
        'numero, ramal, recordingfile, customer_id, carrier_id, did_id, cnpj, tempo_falado, ' ||
        'tempo_cobrado, valor_compra, valor_venda, tarifa, tipo, carrier_channels, customer_channels, ' ||
        'channel_source, hangup_source, desligamento, mes_tx, mes_rx, ip_src, ip_dst, ip_rtp_src, ' ||
        'ip_rtp_dst, codec_nativo, codec_in, codec_out, hangup, status, created_at, updated_at, ' ||
        'numero_discado, numero_convertido, cobrada) VALUES(' ||
        COALESCE(id::text, 'NULL') || ', ' ||
        COALESCE('''' || calldate || '''', 'NULL') || ', ' ||
        COALESCE('''' || REPLACE(clid, '''', '''''') || '''', 'NULL') || ', ' ||
        COALESCE('''' || src || '''', 'NULL') || ', ' ||
        COALESCE('''' || dst || '''', 'NULL') || ', ' ||
        COALESCE('''' || dcontext || '''', 'NULL') || ', ' ||
        COALESCE('''' || channel || '''', 'NULL') || ', ' ||
        COALESCE('''' || dstchannel || '''', 'NULL') || ', ' ||
        COALESCE('''' || lastapp || '''', 'NULL') || ', ' ||
        COALESCE('''' || lastdata || '''', 'NULL') || ', ' ||
        COALESCE(duration::text, 'NULL') || ', ' ||
        COALESCE(billsec::text, 'NULL') || ', ' ||
        COALESCE('''' || disposition || '''', 'NULL') || ', ' ||
        COALESCE('''' || amaflags || '''', 'NULL') || ', ' ||
        COALESCE('''' || accountcode || '''', 'NULL') || ', ' ||
        COALESCE('''' || uniqueid || '''', 'NULL') || ', ' ||
        COALESCE('''' || userfield || '''', 'NULL') || ', ' ||
        COALESCE('''' || prefixo || '''', 'NULL') || ', ' ||
        COALESCE('''' || numero || '''', 'NULL') || ', ' ||
        COALESCE('''' || ramal || '''', 'NULL') || ', ' ||
        COALESCE('''' || recordingfile || '''', 'NULL') || ', ' ||
        COALESCE(customer_id::text, 'NULL') || ', ' ||
        COALESCE(carrier_id::text, 'NULL') || ', ' ||
        COALESCE(did_id::text, 'NULL') || ', ' ||
        COALESCE('''' || cnpj || '''', 'NULL') || ', ' ||
        COALESCE(tempo_falado::text, 'NULL') || ', ' ||
        COALESCE(tempo_cobrado::text, 'NULL') || ', ' ||
        COALESCE(valor_compra::text, 'NULL') || ', ' ||
        COALESCE(valor_venda::text, 'NULL') || ', ' ||
        COALESCE('''' || tarifa || '''', 'NULL') || ', ' ||
        COALESCE('''' || tipo || '''', 'NULL') || ', ' ||
        COALESCE('''' || carrier_channels || '''', 'NULL') || ', ' ||
        COALESCE('''' || customer_channels || '''', 'NULL') || ', ' ||
        COALESCE('''' || channel_source || '''', 'NULL') || ', ' ||
        COALESCE('''' || hangup_source || '''', 'NULL') || ', ' ||
        COALESCE('''' || desligamento || '''', 'NULL') || ', ' ||
        COALESCE(mes_tx::text, 'NULL') || ', ' ||
        COALESCE(mes_rx::text, 'NULL') || ', ' ||
        COALESCE('''' || ip_src || '''', 'NULL') || ', ' ||
        COALESCE('''' || ip_dst || '''', 'NULL') || ', ' ||
        COALESCE('''' || ip_rtp_src || '''', 'NULL') || ', ' ||
        COALESCE('''' || ip_rtp_dst || '''', 'NULL') || ', ' ||
        COALESCE('''' || codec_nativo || '''', 'NULL') || ', ' ||
        COALESCE('''' || codec_in || '''', 'NULL') || ', ' ||
        COALESCE('''' || codec_out || '''', 'NULL') || ', ' ||
        COALESCE('''' || hangup || '''', 'NULL') || ', ' ||
        COALESCE('''' || status || '''', 'NULL') || ', ' ||
        COALESCE('''' || created_at || '''', 'NULL') || ', ' ||
        COALESCE('''' || updated_at || '''', 'NULL') || ', ' ||
        COALESCE('''' || numero_discado || '''', 'NULL') || ', ' ||
        COALESCE('''' || numero_convertido || '''', 'NULL') || ', ' ||
        COALESCE('''' || cobrada || '''', 'NULL') || ');'
    FROM cdrs
    WHERE calldate >= '2025-01-01'  -- Ajuste conforme necessário
    ORDER BY calldate
) TO '/tmp/cdrs_export.sql';
```

**Ou exportação mais simples**:

```bash
# Na linha de comando do servidor antigo
pg_dump -h localhost -U seu_usuario -d base_antiga \
    --table=cdrs \
    --data-only \
    --column-inserts \
    > cdrs_export.sql
```

### 2. Transferir arquivo para o novo servidor

```bash
# Via SCP (exemplo)
scp usuario@servidor_antigo:/tmp/cdrs_export.sql ./storage/imports/

# Ou copiar manualmente para:
# c:\Users\Rafael Benedicto\Documents\Herd\asbc\storage\imports\cdrs_export.sql
```

---

## 🚀 Uso do Comando

### Sintaxe

```bash
php artisan cdr:import {arquivo} [opções]
```

### Opções

| Opção | Descrição |
|-------|-----------|
| `--dry-run` | Preview sem alterar dados |
| `--batch=N` | Tamanho do batch (padrão: 1000) |
| `--skip-duplicates` | Ignora duplicados (ao invés de atualizar) |
| `--reprocess` | Reprocessa tarifação após importação |

---

## 📝 Exemplos de Uso

### 1. Preview (Dry-Run) - SEMPRE FAÇA PRIMEIRO!

**Com CSV (Recomendado)**:
```bash
php artisan cdr:import storage/imports/cdrs_export.csv --dry-run
```

**Com SQL**:
```bash
php artisan cdr:import storage/imports/cdrs_export.sql --dry-run
```

**Output esperado**:
```
╔══════════════════════════════════════════════════════════╗
║           📊 IMPORTAÇÃO DE CDRs                          ║
╚══════════════════════════════════════════════════════════╝

⚠️  MODO DRY-RUN: Nenhum dado será alterado no banco

📁 Arquivo: storage/imports/cdrs_export.csv
📄 Formato: CSV
📦 Batch size: 1000
🔄 Estratégia: Atualizar duplicados (UPSERT)

🔍 Processando arquivo SQL em streaming...

⚙️  Processando em batches de 1000...
 126 batches [████████████████████] Batch 126 - 125,430 CDRs

✓ Total de CDRs processados: 125,430

╔══════════════════════════════════════════════════════════╗
║                    📊 RESUMO                             ║
╚══════════════════════════════════════════════════════════╝

🔍 DRY-RUN - Simulação:
   Total que seria processado: 125,430

⏱️  Tempo total: 0m 12s
📈 Velocidade: 10,452 CDRs/segundo
```

### 2. Importação Real (com atualização de duplicados)

**IMPORTANTE**: Agora usa **UPSERT nativo do PostgreSQL** para máxima performance!

```bash
# Com batch size otimizado (recomendado)
php artisan cdr:import storage/imports/cdrs_export.csv --batch=5000

# Ou com batch padrão
php artisan cdr:import storage/imports/cdrs_export.csv
```

**Output esperado**:
```
╔══════════════════════════════════════════════════════════╗
║                    📊 RESUMO                             ║
╚══════════════════════════════════════════════════════════╝

✅ Inseridos: 98,234
🔄 Atualizados: 27,196
⏭️  Ignorados (duplicados): 0
❌ Erros: 0

⏱️  Tempo total: 0m 45s  ← MUITO mais rápido!
📈 Velocidade: 4.500 CDRs/segundo

💾 Dados salvos com sucesso!
🔄 Todos os CDRs foram marcados como 'Pendente' para reprocessamento
```

**Otimizações Implementadas**:
- ✅ UPSERT nativo do PostgreSQL (`INSERT ... ON CONFLICT`)
- ✅ 1 query por batch ao invés de N queries por registro
- ✅ Batch size padrão aumentado para 5000 (antes era 1000)
- ✅ Índice único em `uniqueid` para performance máxima

### 3. Importação Ignorando Duplicados

```bash
php artisan cdr:import storage/imports/cdrs_export.sql --skip-duplicates
```

CDRs com `uniqueid` já existente serão **ignorados** (não atualizados).

### 4. Importação com Reprocessamento Automático

```bash
php artisan cdr:import storage/imports/cdrs_export.sql --reprocess
```

Após importação, pergunta se deseja iniciar reprocessamento de tarifação.

### 5. Batch Size Customizado

**Para máxima performance** (recomendado):
```bash
php artisan cdr:import storage/imports/cdrs_export.csv --batch=10000
```

**Para volumes muito grandes** (evitar problemas de memória):
```bash
php artisan cdr:import storage/imports/cdrs_export.csv --batch=2000
```

**Recomendações de batch size**:
- ✅ **5000-10000**: Melhor performance para arquivos grandes (recomendado)
- ✅ **2000-5000**: Bom equilíbrio entre performance e uso de memória
- ⚠️ **500-1000**: Use apenas se tiver problemas de memória

---

## 🔑 Pontos Importantes

### 📊 CSV vs SQL: Qual Usar?

**✅ CSV (RECOMENDADO)**:
- ✅ **10x mais rápido** no parsing
- ✅ Parsing extremamente simples e robusto
- ✅ Menor uso de memória
- ✅ Sem problemas com escape de caracteres especiais
- ✅ Arquivo tipicamente menor (sem overhead de SQL)

**SQL (Alternativa)**:
- ✅ Mais compatível entre diferentes bancos
- ✅ Pode ser executado diretamente em outro PostgreSQL
- ⚠️ Parsing mais complexo (multi-linha, escape, etc)
- ⚠️ Mais lento para importação em massa

**Recomendação**: Use CSV sempre que possível. Reserve SQL apenas quando precisar de máxima compatibilidade.

### Campo Único: `uniqueid`

O comando usa `uniqueid` como **chave única** para identificar CDRs duplicados.

- ✅ Se `uniqueid` já existe → **Atualiza** o registro (a menos que use `--skip-duplicates`)
- ✅ Se `uniqueid` não existe → **Insere** novo registro

### Status Sempre "Pendente"

**IMPORTANTE**: Todos os CDRs importados terão `status = 'Pendente'`, **independente** do status no arquivo SQL.

Isso força o **reprocessamento completo** de tarifação nos novos padrões.

### Campos Removidos

O comando **remove automaticamente** o campo `id` do arquivo SQL, pois:
- IDs podem conflitar entre bases diferentes
- PostgreSQL gera IDs automaticamente (auto-increment)

### Timestamps Atualizados

- `created_at` e `updated_at` são atualizados para o **momento da importação**
- Isso garante auditoria correta dos dados

---

## 🔄 Fluxo Completo de Importação

### Passo 1: Preparação

```bash
# 1. Criar diretório de imports (se não existir)
mkdir -p storage/imports

# 2. Verificar espaço em disco
df -h storage/
```

### Passo 2: Exportar da Base Antiga

```sql
-- No PostgreSQL antigo
COPY (SELECT * FROM cdrs WHERE calldate >= '2025-01-01')
TO '/tmp/cdrs_export.sql';
```

### Passo 3: Transferir Arquivo

```bash
# Copiar para diretório de imports
cp /origem/cdrs_export.sql storage/imports/
```

### Passo 4: Preview (Dry-Run)

```bash
php artisan cdr:import storage/imports/cdrs_export.sql --dry-run
```

✅ Verifique o output e confirme que está tudo correto.

### Passo 5: Importação Real

```bash
php artisan cdr:import storage/imports/cdrs_export.sql
```

### Passo 6: Reprocessar Tarifação

```bash
# Opção 1: Via comando (recomendado para volumes grandes)
php artisan queue:work --queue=default --tries=3

# Opção 2: Via interface web
# Acesse: http://asbc.test/maintenance
# Clique em "Tarifar Agora"
```

### Passo 7: Verificar Resultados

```bash
# Total de CDRs importados
php artisan tinker --execute="echo 'Total CDRs: ' . \App\Models\Cdr::count();"

# CDRs pendentes de tarifação
php artisan tinker --execute="echo 'Pendentes: ' . \App\Models\Cdr::where('status', 'Pendente')->count();"

# CDRs tarifados
php artisan tinker --execute="echo 'Tarifados: ' . \App\Models\Cdr::where('status', 'Tarifada')->count();"
```

---

## ⚠️ Troubleshooting

### Erro: "Arquivo não encontrado"

**Problema**: Caminho do arquivo incorreto

**Solução**:
```bash
# Usar caminho absoluto
php artisan cdr:import "C:\Users\Rafael Benedicto\Documents\Herd\asbc\storage\imports\cdrs_export.sql"

# Ou caminho relativo da raiz do projeto
php artisan cdr:import storage/imports/cdrs_export.sql
```

### Erro: "Memory limit exceeded"

**Problema**: Arquivo muito grande (NÃO DEVE MAIS OCORRER)

**Solução Implementada**: O comando agora usa **streaming com generator pattern**:
- Lê arquivo linha por linha (não carrega tudo na memória)
- Processa CDRs em batches conforme lê
- Libera memória automaticamente a cada batch

**Se ainda assim ocorrer**:
```bash
# Reduzir batch size para processar em lotes menores
php artisan cdr:import storage/imports/cdrs_export.sql --batch=500

# Última opção: aumentar memory_limit
php -d memory_limit=512M artisan cdr:import storage/imports/cdrs_export.sql
```

### Performance Lenta

**Problema**: Muitas queries de verificação de duplicados

**Solução**:
```bash
# Se tem certeza que NÃO há duplicados, use:
php artisan cdr:import storage/imports/cdrs_export.sql --skip-duplicates

# Isso pula a verificação de existência
```

### Formato SQL Incompatível

**Problema**: Parser não reconhece o formato do INSERT

**Solução**: Usar formato `--column-inserts` no pg_dump:
```bash
pg_dump -h localhost -U user -d database \
    --table=cdrs \
    --data-only \
    --column-inserts \
    > cdrs_export.sql
```

---

## 📊 Logs e Auditoria

### Logs do Laravel

```bash
# Acompanhar em tempo real
tail -f storage/logs/laravel.log | grep "Importação de CDRs"
```

### Verificar Última Importação

```bash
# Ver último log de importação
grep "Importação de CDRs concluída" storage/logs/laravel.log | tail -1
```

---

## 🎯 Boas Práticas

1. ✅ **SEMPRE** faça dry-run primeiro
2. ✅ Faça backup da base nova antes de importar
3. ✅ Exporte por períodos (evite arquivos gigantes)
4. ✅ Monitore logs durante importação
5. ✅ Verifique totais após importação
6. ✅ Reprocesse tarifação em horário de baixo uso

---

## 📚 Referências

- **Comando**: `app/Console/Commands/ImportCdrsCommand.php`
- **Modelo CDR**: `app/Models/Cdr.php`
- **Migration CDRs**: `database/migrations/2024_09_16_173145_create_cdrs_table.php`

---

**Autor**: Claude Sonnet 4.5
**Data**: 2025-12-27
**Status**: ✅ Pronto para Uso
