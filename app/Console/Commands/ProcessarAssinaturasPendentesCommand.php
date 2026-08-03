<?php

namespace App\Console\Commands;

use App\Services\AssinaturaProcessorService;
use App\Services\LogAssinaturaDocumentoService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessarAssinaturasPendentesCommand extends Command
{
    protected $signature = 'assinaturas:processar-pendentes';

    protected $description = 'Consulta o log de assinatura de documentos por registos PENDENTE, assina-os e atualiza o status para SUCESSO/ERRO.';

    public function __construct(
        private readonly LogAssinaturaDocumentoService $logService,
        private readonly AssinaturaProcessorService $processorService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $pendentes = $this->logService->listarPorStatus('PENDENTE');

        if (empty($pendentes)) {
            $this->info('Nenhum registo PENDENTE encontrado.');

            return self::SUCCESS;
        }

        $this->info(count($pendentes) . ' registo(s) PENDENTE encontrado(s).');

        foreach ($pendentes as $registo) {
            $id = $registo['id'];

            try {
                $resultado = $this->processorService->processar([
                    'file_id' => $registo['docId'],
                    'signature_id' => $registo['imgAssinaturaId'] ?? null,
                    'position' => $registo['positionAssinatura'],
                    'nome_assinatura' => $registo['nomeAssinatura'],
                    'contraprova' => $registo['contraprova'] ?? '',
                    'numero_processo' => $registo['numeroProcesso'],
                    'link' => $registo['linkValidacao'] ?? null,
                    'pelo' => $registo['pelo'] ?? '',
                    'competencia' => $registo['complemento'] ?? '',
                ]);

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
