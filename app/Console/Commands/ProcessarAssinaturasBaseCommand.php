<?php

namespace App\Console\Commands;

use App\Services\AssinaturaProcessorService;
use App\Services\LogAssinaturaDocumentoService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Lógica comum aos jobs de assinatura: lê os registos PENDENTE, assina cada um
 * e atualiza o status para SUCESSO/ERRO.
 * Cada job só define que registos apanha (filtrar) e como assina (assinar).
 */
abstract class ProcessarAssinaturasBaseCommand extends Command
{
    public const TIPO_RENOVACAO_ALVARA = 'RENOVACAO_ALVARA';

    public function __construct(
        protected readonly LogAssinaturaDocumentoService $logService,
        protected readonly AssinaturaProcessorService $processorService,
    ) {
        parent::__construct();
    }

    /** Indica se o registo deve ser processado por este job. */
    abstract protected function filtrar(array $registo): bool;

    /** Assina o documento do registo e devolve a resposta do upload. */
    abstract protected function assinar(array $registo): array;

    public static function isRenovacaoAlvara(array $registo): bool
    {
        return strtoupper(trim((string) ($registo['tipoDoc'] ?? ''))) === self::TIPO_RENOVACAO_ALVARA;
    }

    public function handle(): int
    {
        $pendentes = array_values(array_filter(
            $this->logService->listarPorStatus('PENDENTE'),
            fn (array $registo) => $this->filtrar($registo)
        ));

        if (empty($pendentes)) {
            $this->info('Nenhum registo PENDENTE encontrado.');

            return self::SUCCESS;
        }

        $this->info(count($pendentes) . ' registo(s) PENDENTE encontrado(s).');

        foreach ($pendentes as $registo) {
            $id = $registo['id'];

            try {
                $resultado = $this->assinar($registo);

                // O 'blobContent' traz o PDF inteiro em base64: não vai para logs nem para o resposta_api.
                $resultadoResumo = $resultado;
                unset($resultadoResumo['data']['blobContent'], $resultadoResumo['blobContent']);

                Log::info("Documento assinado e enviado para o registo {$id}.", ['resultado' => $resultadoResumo]);

                $idNewRetornado = $resultado['id'] ?? $resultado['data']['id'] ?? null;

                $this->logService->atualizarStatus(
                    $id,
                    'SUCESSO',
                    null,
                    $resultadoResumo,
                    $idNewRetornado
                );

                $this->info("Registo {$id}: assinado com sucesso.");
            } catch (Throwable $e) {
                Log::error("Erro ao processar registo de assinatura {$id}: " . $e->getMessage());

                try {
                    $this->logService->atualizarStatus($id, 'ERRO', $e->getMessage());
                } catch (Throwable $erroAtualizacao) {
                    Log::error("Erro ao atualizar status de ERRO do registo {$id}: " . $erroAtualizacao->getMessage());
                }

                $this->error("Registo {$id}: falhou - {$e->getMessage()}");
            }
        }

        return self::SUCCESS;
    }
}
