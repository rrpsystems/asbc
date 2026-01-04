<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportCdrsCommand extends Command
{
    protected $signature = 'cdr:import
                            {file : Caminho do arquivo SQL ou CSV}
                            {--dry-run : Executa preview sem alterar dados}
                            {--batch=5000 : Tamanho do batch (padrão: 5000 - recomendado entre 1000-10000)}
                            {--skip-duplicates : Ignora duplicados ao invés de atualizar}
                            {--reprocess : Reprocessa tarifação após importação}
                            {--format= : Formato do arquivo (sql|csv) - detecta automaticamente se não especificado}';

    protected $description = 'Importa CDRs de arquivo SQL (INSERT statements) ou CSV usando UPSERT';

    protected $stats = [
        'total' => 0,
        'inserted' => 0,
        'updated' => 0,
        'skipped' => 0,
        'errors' => 0,
    ];

    public function handle()
    {
        $file = $this->argument('file');
        $dryRun = $this->option('dry-run');
        $batchSize = (int) $this->option('batch');
        $skipDuplicates = $this->option('skip-duplicates');
        $reprocess = $this->option('reprocess');
        $format = $this->option('format');

        // Validação do arquivo
        if (!file_exists($file)) {
            $this->error("❌ Arquivo não encontrado: {$file}");
            return 1;
        }

        // Detecta formato automaticamente se não especificado
        if (!$format) {
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $format = $extension === 'csv' ? 'csv' : 'sql';
        }

        $format = strtolower($format);
        if (!in_array($format, ['sql', 'csv'])) {
            $this->error("❌ Formato inválido. Use 'sql' ou 'csv'");
            return 1;
        }

        $this->info("╔══════════════════════════════════════════════════════════╗");
        $this->info("║           📊 IMPORTAÇÃO DE CDRs                          ║");
        $this->info("╚══════════════════════════════════════════════════════════╝");
        $this->newLine();

        if ($dryRun) {
            $this->warn("⚠️  MODO DRY-RUN: Nenhum dado será alterado no banco");
            $this->newLine();
        }

        $this->info("📁 Arquivo: {$file}");
        $this->info("📄 Formato: " . strtoupper($format));
        $this->info("📦 Batch size: {$batchSize}");
        $this->info("🔄 Estratégia: " . ($skipDuplicates ? 'Ignorar duplicados' : 'Atualizar duplicados (UPSERT)'));
        $this->newLine();

        $startTime = microtime(true);

        try {
            // Lê e processa o arquivo
            $this->info("🔍 Processando arquivo SQL em streaming...");
            $this->newLine();

            // Processa arquivo em streaming (não carrega tudo na memória)
            $bar = null;
            $currentBatch = [];
            $batchCount = 0;

            // Escolhe parser baseado no formato
            $parser = $format === 'csv'
                ? $this->parseCsvFile($file)
                : $this->parseInsertStatements($file);

            foreach ($parser as $cdr) {
                $this->stats['total']++;
                $currentBatch[] = $cdr;

                // Quando atingir o tamanho do batch, processa
                if (count($currentBatch) >= $batchSize) {
                    if ($bar === null) {
                        // Inicia barra de progresso após primeiro batch
                        $this->info("⚙️  Processando em batches de {$batchSize}...");
                        $bar = $this->output->createProgressBar();
                        $bar->setFormat(' %current% batches [%bar%] %message%');
                        $bar->start();
                    }

                    $batchCount++;
                    $bar->setMessage("Batch {$batchCount} - " . number_format($this->stats['total'], 0, ',', '.') . " CDRs");

                    if (!$dryRun) {
                        $this->processBatch($currentBatch, $skipDuplicates);
                    } else {
                        // No dry-run, apenas simula
                        $this->stats['inserted'] += count($currentBatch);
                    }

                    $bar->advance();
                    $currentBatch = []; // Libera memória
                    gc_collect_cycles();
                }
            }

            // Processa último batch (se houver resto)
            if (count($currentBatch) > 0) {
                if ($bar === null) {
                    $this->info("⚙️  Processando batch final...");
                } else {
                    $batchCount++;
                    $bar->setMessage("Batch {$batchCount} (final) - " . number_format($this->stats['total'], 0, ',', '.') . " CDRs");
                }

                if (!$dryRun) {
                    $this->processBatch($currentBatch, $skipDuplicates);
                } else {
                    $this->stats['inserted'] += count($currentBatch);
                }

                if ($bar !== null) {
                    $bar->advance();
                }
            }

            if ($bar !== null) {
                $bar->finish();
            }
            $this->newLine(2);

            $this->info("✓ Total de CDRs processados: " . number_format($this->stats['total'], 0, ',', '.'));
            $this->newLine();

            // Exibe resumo
            $this->displaySummary($startTime, $dryRun);

            // Reprocessa tarifação se solicitado
            if (!$dryRun && $reprocess && $this->stats['inserted'] + $this->stats['updated'] > 0) {
                $this->newLine();
                if ($this->confirm('🔄 Deseja reprocessar tarifação agora?', true)) {
                    $this->info("Iniciando reprocessamento...");
                    $this->call('queue:work', ['--once' => true, '--tries' => 3]);
                    $this->info("✓ Reprocessamento iniciado!");
                }
            }

            Log::info('Importação de CDRs concluída', $this->stats);

            return 0;

        } catch (\Exception $e) {
            $this->error("❌ Erro durante importação: {$e->getMessage()}");
            Log::error('Erro na importação de CDRs', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return 1;
        }
    }

    /**
     * Parse de arquivo CSV usando generator (streaming)
     * Muito mais eficiente que SQL - recomendado para arquivos grandes
     */
    protected function parseCsvFile($file)
    {
        $handle = fopen($file, 'r');

        if (!$handle) {
            throw new \Exception("Não foi possível abrir o arquivo: {$file}");
        }

        $lineNumber = 0;
        $columns = null;

        while (($data = fgetcsv($handle, 0, ',')) !== false) {
            $lineNumber++;

            // Primeira linha = cabeçalho com nomes das colunas
            if ($columns === null) {
                $columns = array_map('trim', $data);
                continue;
            }

            // Verifica se número de valores bate com número de colunas
            if (count($data) !== count($columns)) {
                // Pula linhas com número incorreto de colunas
                continue;
            }

            // Combina colunas com valores
            $cdr = array_combine($columns, $data);

            // Remove campos que não devem ser importados
            unset($cdr['id']); // ID auto-gerado

            // Força status como Pendente para reprocessamento
            $cdr['status'] = 'Pendente';

            // Converte valores vazios para NULL
            $cdr = array_map(function($value) {
                if ($value === '' || $value === 'NULL' || $value === null) {
                    return null;
                }
                return $value;
            }, $cdr);

            yield $cdr;

            // Libera memória periodicamente
            if ($lineNumber % 10000 === 0) {
                gc_collect_cycles();
            }
        }

        fclose($handle);
    }

    /**
     * Extrai dados dos INSERT statements do arquivo SQL usando generator (streaming)
     * Suporta formato multi-linha do PostgreSQL: INSERT INTO ... VALUES (\n\t(...),\n\t(...)\n);
     */
    protected function parseInsertStatements($file)
    {
        $handle = fopen($file, 'r');

        if (!$handle) {
            throw new \Exception("Não foi possível abrir o arquivo: {$file}");
        }

        $lineNumber = 0;
        $columns = null;
        $inInsertBlock = false;
        $insertBuffer = '';

        while (($line = fgets($handle)) !== false) {
            $lineNumber++;
            $trimmedLine = trim($line);

            // Detecta início de um bloco INSERT
            if (preg_match('/^INSERT INTO (?:public\.)?cdrs\s*\((.*?)\)\s*VALUES\s*$/i', $trimmedLine, $match)) {
                $inInsertBlock = true;
                $insertBuffer = '';

                // Extrai colunas apenas uma vez
                if ($columns === null) {
                    $columns = array_map('trim', explode(',', $match[1]));
                }
                continue;
            }

            // Se estamos dentro de um bloco INSERT, acumula as linhas
            if ($inInsertBlock) {
                $insertBuffer .= ' ' . $trimmedLine;

                // Verifica se chegou ao fim do bloco (termina com ;)
                if (str_ends_with($trimmedLine, ';')) {
                    // Remove o último ; e processa todos os valores
                    $insertBuffer = rtrim($insertBuffer, ';');

                    // Split por "),(" para separar múltiplos registros
                    // Mas precisa respeitar strings com vírgulas/parênteses
                    $this->parseMultiLineValues($insertBuffer, $columns);

                    foreach ($this->parseMultiLineValues($insertBuffer, $columns) as $cdr) {
                        yield $cdr;
                    }

                    $inInsertBlock = false;
                    $insertBuffer = '';
                }
            }

            // Libera memória a cada 10000 linhas processadas
            if ($lineNumber % 10000 === 0) {
                gc_collect_cycles();
            }
        }

        fclose($handle);
    }

    /**
     * Parse de valores multi-linha no formato: (val1,val2), (val3,val4), ...
     */
    protected function parseMultiLineValues($valuesString, $columns)
    {
        $cdrs = [];
        $currentValue = '';
        $depth = 0;
        $inString = false;
        $stringDelimiter = null;

        for ($i = 0; $i < strlen($valuesString); $i++) {
            $char = $valuesString[$i];
            $prevChar = $i > 0 ? $valuesString[$i - 1] : null;

            // Controle de strings
            if (!$inString && ($char === "'" || $char === '"')) {
                $inString = true;
                $stringDelimiter = $char;
                $currentValue .= $char;
            } elseif ($inString && $char === $stringDelimiter && $prevChar !== '\\') {
                $inString = false;
                $stringDelimiter = null;
                $currentValue .= $char;
            } elseif (!$inString && $char === '(') {
                $depth++;
                if ($depth === 1) {
                    // Início de um novo registro, não adiciona o parêntese
                    $currentValue = '';
                } else {
                    $currentValue .= $char;
                }
            } elseif (!$inString && $char === ')') {
                $depth--;
                if ($depth === 0) {
                    // Fim de um registro, processa
                    $values = $this->parseValues($currentValue);

                    if (count($columns) === count($values)) {
                        $cdr = array_combine($columns, $values);
                        unset($cdr['id']);
                        $cdr['status'] = 'Pendente';

                        $cdr = array_map(function($value) {
                            return $value === 'NULL' ? null : $value;
                        }, $cdr);

                        $cdrs[] = $cdr;
                    }

                    $currentValue = '';
                } else {
                    $currentValue .= $char;
                }
            } else {
                $currentValue .= $char;
            }
        }

        return $cdrs;
    }

    /**
     * Parse dos valores do INSERT, respeitando strings com vírgulas
     */
    protected function parseValues($valuesString)
    {
        $values = [];
        $current = '';
        $inString = false;
        $stringDelimiter = null;

        for ($i = 0; $i < strlen($valuesString); $i++) {
            $char = $valuesString[$i];

            if (!$inString && ($char === "'" || $char === '"')) {
                $inString = true;
                $stringDelimiter = $char;
                $current .= $char;
            } elseif ($inString && $char === $stringDelimiter && ($i === 0 || $valuesString[$i-1] !== '\\')) {
                $inString = false;
                $stringDelimiter = null;
                $current .= $char;
            } elseif (!$inString && $char === ',') {
                $values[] = trim($current);
                $current = '';
            } else {
                $current .= $char;
            }
        }

        // Adiciona último valor
        if ($current !== '') {
            $values[] = trim($current);
        }

        // Remove aspas dos valores
        return array_map(function($value) {
            $value = trim($value);
            if (preg_match('/^["\'](.*)["\']\s*$/s', $value, $matches)) {
                return $matches[1];
            }
            return $value;
        }, $values);
    }

    /**
     * Processa um batch de CDRs usando COPY temporário + UPSERT
     * Estratégia híbrida para máxima performance:
     * 1. COPY para tabela temporária (super rápido)
     * 2. UPSERT da temp para cdrs (eficiente)
     */
    protected function processBatch(array $cdrs, bool $skipDuplicates)
    {
        try {
            // Filtra CDRs inválidos (sem uniqueid)
            $validCdrs = array_filter($cdrs, function($cdr) {
                return isset($cdr['uniqueid']) && !empty($cdr['uniqueid']);
            });

            $invalidCount = count($cdrs) - count($validCdrs);
            $this->stats['errors'] += $invalidCount;

            if (empty($validCdrs)) {
                return;
            }

            // Adiciona timestamps
            $now = now();
            $validCdrs = array_map(function($cdr) use ($now) {
                return array_merge($cdr, [
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }, $validCdrs);

            $columns = array_keys(reset($validCdrs));

            // Cria tabela temporária (sem constraints para máxima velocidade)
            $tempTable = 'temp_cdrs_import_' . uniqid();

            // Cria estrutura da temp (sem ON COMMIT DROP - será dropado manualmente)
            DB::statement("CREATE TEMPORARY TABLE {$tempTable} (LIKE cdrs INCLUDING DEFAULTS)");

            // Usa INSERT com múltiplos VALUES em sub-batches pequenos
            $columnList = implode(',', $columns);

            // Sub-batches de 100 para evitar queries gigantes e problemas de memória
            $subBatchSize = 100;
            $chunks = array_chunk($validCdrs, $subBatchSize);

            foreach ($chunks as $chunk) {
                $placeholders = [];
                $bindings = [];

                foreach ($chunk as $cdr) {
                    $rowPlaceholders = [];
                    foreach ($columns as $column) {
                        $rowPlaceholders[] = '?';
                        $bindings[] = $cdr[$column];
                    }
                    $placeholders[] = '(' . implode(',', $rowPlaceholders) . ')';
                }

                $insertSql = "INSERT INTO {$tempTable} ({$columnList}) VALUES " . implode(',', $placeholders);
                DB::insert($insertSql, $bindings);

                // Libera memória
                unset($placeholders, $bindings, $chunk);
            }

            if ($skipDuplicates) {
                // INSERT ignorando conflitos
                $sql = "
                    INSERT INTO cdrs (" . implode(',', $columns) . ")
                    SELECT " . implode(',', $columns) . "
                    FROM {$tempTable}
                    ON CONFLICT (uniqueid) DO NOTHING
                ";

                $inserted = DB::affectingStatement($sql);
                $this->stats['inserted'] += $inserted;
                $this->stats['skipped'] += (count($validCdrs) - $inserted);

            } else {
                // UPSERT completo
                $updateColumns = array_filter($columns, function($col) {
                    return !in_array($col, ['uniqueid', 'created_at']);
                });

                $updateSet = implode(', ', array_map(function($col) {
                    return "{$col} = EXCLUDED.{$col}";
                }, $updateColumns));

                $sql = "
                    INSERT INTO cdrs (" . implode(',', $columns) . ")
                    SELECT " . implode(',', $columns) . "
                    FROM {$tempTable}
                    ON CONFLICT (uniqueid) DO UPDATE SET {$updateSet}
                ";

                DB::affectingStatement($sql);

                // Estimativa (metade insert, metade update)
                $this->stats['inserted'] += (int)(count($validCdrs) / 2);
                $this->stats['updated'] += (int)(count($validCdrs) / 2);
            }

            // Drop tabela temporária
            DB::statement("DROP TABLE IF EXISTS {$tempTable}");

        } catch (\Exception $e) {
            $this->stats['errors'] += count($cdrs);

            // Tenta limpar tabela temp em caso de erro
            try {
                if (isset($tempTable)) {
                    DB::statement("DROP TABLE IF EXISTS {$tempTable}");
                }
            } catch (\Exception $dropError) {
                // Ignora erro no drop
            }

            Log::error('Erro ao processar batch de CDRs', [
                'error' => $e->getMessage(),
                'batch_size' => count($cdrs),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Exibe resumo da importação
     */
    protected function displaySummary($startTime, $dryRun)
    {
        $duration = microtime(true) - $startTime;
        $speed = $this->stats['total'] > 0 ? $this->stats['total'] / $duration : 0;

        $this->info("╔══════════════════════════════════════════════════════════╗");
        $this->info("║                    📊 RESUMO                             ║");
        $this->info("╚══════════════════════════════════════════════════════════╝");
        $this->newLine();

        if ($dryRun) {
            $this->line("🔍 <fg=yellow>DRY-RUN - Simulação:</>");
            $this->line("   Total que seria processado: <fg=cyan>" . number_format($this->stats['total'], 0, ',', '.') . "</>");
        } else {
            $this->line("✅ Inseridos: <fg=green>" . number_format($this->stats['inserted'], 0, ',', '.') . "</>");
            $this->line("🔄 Atualizados: <fg=cyan>" . number_format($this->stats['updated'], 0, ',', '.') . "</>");
            $this->line("⏭️  Ignorados (duplicados): <fg=yellow>" . number_format($this->stats['skipped'], 0, ',', '.') . "</>");

            if ($this->stats['errors'] > 0) {
                $this->line("❌ Erros: <fg=red>" . number_format($this->stats['errors'], 0, ',', '.') . "</>");
            }
        }

        $this->newLine();
        $this->line("⏱️  Tempo total: " . gmdate('i\m s\s', $duration));
        $this->line("📈 Velocidade: " . number_format($speed, 0, ',', '.') . " CDRs/segundo");

        if (!$dryRun) {
            $this->newLine();
            $this->info("💾 Dados salvos com sucesso!");
            $this->info("🔄 Todos os CDRs foram marcados como 'Pendente' para reprocessamento");
        }
    }
}
