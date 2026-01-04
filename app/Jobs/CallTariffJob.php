<?php

namespace App\Jobs;

use App\Exceptions\Tariff\InvalidCdrDataException;
use App\Exceptions\Tariff\RateNotFoundException;
use App\Models\Cdr;
use App\Services\AlertService;
use App\Services\CallTariffService;
use App\Services\RevenueBatchDispatcher;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CallTariffJob implements ShouldQueue
{
    use Queueable;

    /**
     * Número máximo de tentativas
     */
    public $tries = 3;

    /**
     * Timeout em segundos
     */
    public $timeout = 120;

    /**
     * Tempo de espera entre tentativas (em segundos)
     */
    public $backoff = [60, 300, 900]; // 1min, 5min, 15min

    /**
     * ID único para prevenir duplicatas
     */
    public $uniqueFor = 3600; // 1 hora

    protected int $cdrId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $cdrId)
    {
        $this->cdrId = $cdrId;
    }

    /**
     * Obtém o ID único do job para prevenir duplicatas
     */
    public function uniqueId(): string
    {
        return 'cdr-tariff-' . $this->cdrId;
    }

    /**
     * Execute the job.
     */
    public function handle(
        CallTariffService $tariffService,
        RevenueBatchDispatcher $batchDispatcher
    ): void
    {
        $lock = Cache::lock("cdr_processing:{$this->cdrId}", 300);

        if (!$lock->get()) {
            Log::warning('CDR já em processamento', ['cdr_id' => $this->cdrId]);
            return;
        }

        try {
            $cdr = null;

            // Usa transaction com timeout para evitar deadlocks
            DB::transaction(function () use ($tariffService, &$cdr) {
                // Lock pessimista no registro com timeout (nowait evita deadlock)
                $cdr = Cdr::lockForUpdate()->find($this->cdrId);

                if (!$cdr) {
                    throw new \RuntimeException("CDR {$this->cdrId} não encontrado");
                }

                // Verifica se já foi processado
                if ($cdr->status === 'Tarifada') {
                    Log::info('CDR já tarifado, pulando', ['cdr_id' => $this->cdrId]);
                    return;
                }

                // Calcula tarifas
                $tarifas = $tariffService->calcularTarifa($cdr);

                // Atualiza CDR
                $cdr->valor_compra = $tarifas['compra'];
                $cdr->valor_venda = $tarifas['venda'];
                $cdr->tempo_cobrado = $tarifas['tempo_cobrado'];
                $cdr->status = 'Tarifada';
                $cdr->save();
            });

            // Após tarifar com sucesso, adiciona ao batch de resumo mensal
            if ($cdr && $cdr->status === 'Tarifada') {
                $calldate = Carbon::parse($cdr->calldate);
                $batchDispatcher->addCdrToBatch(
                    $cdr->id,
                    $cdr->customer_id,
                    $calldate->month,
                    $calldate->year
                );
            }

        } catch (InvalidCdrDataException $e) {
            // Erro de dados - não adianta retry
            $this->markAsInvalidData($e);

        } catch (RateNotFoundException $e) {
            // Tarifa não encontrada - retry com backoff maior
            $this->markAsRateNotFound($e);
            throw $e;

        } catch (\Illuminate\Database\QueryException $e) {
            // Deadlock ou timeout do banco - retry pode resolver
            if ($this->isDeadlock($e)) {
                Log::warning('Deadlock detectado, tentando novamente', [
                    'cdr_id' => $this->cdrId,
                    'attempt' => $this->attempts(),
                    'error' => $e->getMessage(),
                ]);
                throw $e; // Permite retry
            }

            // Outro erro de query - marca como erro e faz retry
            $this->markAsError($e);
            throw $e;

        } catch (\Exception $e) {
            // Erro genérico - retry normal
            Log::error('Erro genérico ao processar CDR', [
                'cdr_id' => $this->cdrId,
                'exception_class' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile() . ':' . $e->getLine(),
            ]);
            $this->markAsError($e);
            throw $e;

        } finally {
            $lock->release();
        }
    }

    /**
     * Executado quando o job falha após todas as tentativas
     */
    public function failed(\Throwable $exception): void
    {
        Log::critical('Job de tarifação falhou após todas as tentativas', [
            'cdr_id' => $this->cdrId,
            'exception_class' => get_class($exception),
            'erro_final' => $exception->getMessage(),
        ]);

        try {
            $cdr = Cdr::find($this->cdrId);

            if ($cdr) {
                $cdr->status = 'Erro_Permanente';
                $cdr->save();

                // Cria alerta
                $alertService = app(AlertService::class);
                $alertService->alertTarifacaoError($this->cdrId, $exception->getMessage());
            }

        } catch (\Exception $e) {
            Log::error('Erro ao marcar CDR como falho', [
                'cdr_id' => $this->cdrId,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Marca CDR como dados inválidos
     */
    private function markAsInvalidData(\Exception $e): void
    {
        try {
            $cdr = Cdr::find($this->cdrId);
            if ($cdr) {
                $cdr->status = 'Dados_Invalidos';
                $cdr->save();
            }
        } catch (\Exception $ex) {
            Log::error('Erro ao marcar CDR como dados inválidos', [
                'cdr_id' => $this->cdrId,
                'error' => $ex->getMessage()
            ]);
        }

        Log::error('CDR com dados inválidos', [
            'cdr_id' => $this->cdrId,
            'erro' => $e->getMessage()
        ]);
    }

    /**
     * Marca CDR como tarifa não encontrada
     */
    private function markAsRateNotFound(\Exception $e): void
    {
        try {
            $cdr = Cdr::find($this->cdrId);
            if ($cdr) {
                $cdr->status = 'Tarifa_Nao_Encontrada';
                $cdr->save();
            }
        } catch (\Exception $ex) {
            Log::error('Erro ao marcar CDR como tarifa não encontrada', [
                'cdr_id' => $this->cdrId,
                'error' => $ex->getMessage()
            ]);
        }

        Log::warning('Tarifa não encontrada para CDR', [
            'cdr_id' => $this->cdrId,
            'erro' => $e->getMessage()
        ]);
    }

    /**
     * Marca CDR como erro
     */
    private function markAsError(\Exception $e): void
    {
        try {
            $cdr = Cdr::find($this->cdrId);
            if ($cdr && $cdr->status !== 'Tarifada') {
                $cdr->status = 'Erro_Tarifa';
                $cdr->save();
            }
        } catch (\Exception $ex) {
            Log::error('Erro ao marcar CDR como erro', [
                'cdr_id' => $this->cdrId,
                'error' => $ex->getMessage()
            ]);
        }

        Log::error('Erro ao processar CDR', [
            'cdr_id' => $this->cdrId,
            'erro' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
    }

    /**
     * Detecta se a exceção é um deadlock
     */
    private function isDeadlock(\Illuminate\Database\QueryException $e): bool
    {
        $errorCode = $e->errorInfo[0] ?? null;
        $message = $e->getMessage();

        // PostgreSQL deadlock codes
        return $errorCode === '40P01' ||  // deadlock_detected
               $errorCode === '40001' ||  // serialization_failure
               str_contains($message, 'deadlock') ||
               str_contains($message, 'lock timeout');
    }

    /**
     * Define quando o job deve parar de tentar retry
     */
    public function retryUntil(): \DateTime
    {
        // Retry strategy diferenciado baseado no número de tentativas
        return match($this->attempts()) {
            1 => now()->addMinutes(1),
            2 => now()->addMinutes(5),
            default => now()->addMinutes(15),
        };
    }
}
