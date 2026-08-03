<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;

class LogAssinaturaDocumentoService extends BaseApiService
{
    private const ENDPOINT = 'log-assinatura-documento';

    /**
     * @return array<int, array<string, mixed>>
     */
    public function listarPorStatus(string $status = 'PENDENTE'): array
    {
        $response = $this->get(self::ENDPOINT, ['status' => $status]);

        if ($response->failed()) {
            Log::error('Erro ao consultar o log de assinatura de documentos', [
                'status_http' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new Exception('Erro ao consultar o log de assinatura de documentos.');
        }

        $dados = $response->json();

        return $dados['data'] ?? $dados ?? [];
    }

    public function atualizarStatus(
        int $id,
        string $status,
        ?string $mensagemErro = null,
        mixed $respostaApi = null,
        ?int $idNewRetornado = null
    ): void {
        $payload = array_filter([
            'status' => $status,
            'mensagemErro' => $mensagemErro,
            'respostaApi' => is_array($respostaApi) ? json_encode($respostaApi) : $respostaApi,
            'idNewRetornado' => $idNewRetornado,
        ], fn ($valor) => $valor !== null);

        $endpoint = self::ENDPOINT . '/' . $id;
        $response = $this->put($endpoint, $payload);

        if ($response->failed()) {
            Log::error('Erro ao atualizar o status no log de assinatura de documentos', [
                'endpoint' => $endpoint,
                'payload' => $payload,
                'status_http' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new Exception("Erro ao atualizar o status do registo {$id} no log de assinatura de documentos (HTTP {$response->status()}): {$response->body()}");
        }
    }
}
