<?php

namespace App\Services;

use App\Exceptions\DocumentoNaoEncontradoException;
use App\Models\AssinaturaDto;
use App\Models\CertidaoMatricialDto;
use App\Models\CompraVenda;
use App\Models\DoacaoDto;
use App\Models\PartilhaDto;
use App\Models\SucessorioDto;
use App\Models\RemForoDto;
use App\Models\TerrenoDto;
use App\Services\Traits\GatewayClientTrait;
use Exception;
use Illuminate\Support\Facades\Log;


class AppService extends BaseApiService
{

     use GatewayClientTrait;

    private function getDto(string $endpoint, string $dtoClass , array $params = [], array $headers = []): object
    {
        $response = $this->get($endpoint,  $params, $headers);

        if ($response->status() === 404) {
            Log::warning('getDto: API devolveu 404', [
                'endpoint' => $endpoint,
                'body' => $response->body(),
            ]);

            throw new DocumentoNaoEncontradoException('Documento não encontrado.');
        }

        if ($response->failed()) {
            $erroApi = $response->json('message') ?? $response->json('error') ?? $response->body();

            throw new Exception($erroApi ?: 'Erro ao consumir API.');
        }

        $dadosApi = $response->json();

        if (!isset($dadosApi['data'])) {
            Log::warning('getDto: resposta sem chave "data"', [
                'endpoint' => $endpoint,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new DocumentoNaoEncontradoException('Documento não encontrado.');
        }

        return new $dtoClass($dadosApi['data']);
    }
   
    public function getDadosCertidaoMatricial(int $id): CertidaoMatricialDto
    {
        return $this->getDto(
            "reports/certidao_matricial/{$id}",
            CertidaoMatricialDto::class,
            [],
            $this->reportHeaders()
        );
    }

    public function getCompraVenda(int $id): CompraVenda
    {
        return $this->getDto(
            "reports/compra-venda/{$id}",
            CompraVenda::class,
            [],
            $this->reportHeaders()
        );
    }

    public function getDoacao(int $id): DoacaoDto
    {
        return $this->getDto(
            "reports/iup-doacao/{$id}",
            DoacaoDto::class,
            [],
            $this->reportHeaders()
        );
    }

    public function getSucessorio(int $id): SucessorioDto
    {
        return $this->getDto(
            "reports/iup-sucessorio/{$id}",
            SucessorioDto::class,
            [],
            $this->reportHeaders()
        );
    }

    public function getPartilha(int $id): PartilhaDto
    {
        return $this->getDto(
            "reports/iup-partilha/{$id}",
            PartilhaDto::class,
            [],
            $this->reportHeaders()
        );
    }

    public function getRemForo(int $id): RemForoDto
    {
        return $this->getDto(
            "reports/iup-remicao-foro/{$id}",
            RemForoDto::class,
            [],
            $this->reportHeaders()
        );
    }

    public function getTerreno(int $id): TerrenoDto
    {
        return $this->getDto(
            "reports/iup-terreno/{$id}",
            TerrenoDto::class,
            [],
            $this->reportHeaders()
        );
    }

    public function getDocumentData(int $id){

        $response = $this->get("/documento/{$id}");

        if ($response->failed()) {
            throw new \Exception('Erro ao obter documento.');
        }

        return $response->json();
    }

    /**
     * Busca um documento (PDF, imagem, etc.) pelo ID e devolve o conteúdo binário já descodificado.
     */
    public function getDocumentBinary(int $id): array
    {
        $dadosApi = $this->getDocumentData($id);

        $base64 = $dadosApi['data']['blobContent'] ?? null;
        $mimeType = $dadosApi['data']['mimeType'] ?? null;

        if (!$base64) {
            throw new Exception("Documento {$id} não encontrado ou sem conteúdo.");
        }

        $content = base64_decode($base64, true);

        if ($content === false) {
            throw new Exception("Erro ao descodificar o documento {$id}.");
        }

        return ['content' => $content, 'mimeType' => $mimeType];
    }

    /**
     * Envia o conteúdo binário de um documento (ex: PDF assinado) para a API de documentos.
     */
    public function uploadDocument(string $contents, string $filename, string $mimeType = 'application/pdf'): array
    {
        $response = $this->postFile('/documento', 'file', $contents, $filename, $mimeType);

        if ($response->failed()) {
            throw new Exception('Erro ao enviar documento assinado.');
        }

        return $response->json();
    }


    public function getAtestado(string $userName, string $email, string $idProcesso): AssinaturaDto
    {
        return $this->getDto(
            '/assinatura',
            AssinaturaDto::class,
            [
                'userName'   => $userName,
                'email'      => $email,
                'idProcesso' => $idProcesso,
            ]
        );
    }

    
}