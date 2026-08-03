<?php

namespace App\Services;

use App\Models\AssinaturaDto;
use App\Models\CertidaoMatricialDto;
use App\Models\CompraVenda;
use App\Models\DoacaoDto;
use App\Models\PartilhaDto;
use App\Models\RemForoDto;
use App\Models\TerrenoDto;
use App\Services\Traits\GatewayClientTrait;
use Exception;


class AppService extends BaseApiService
{

     use GatewayClientTrait;

    private function getDto(string $endpoint, string $dtoClass , array $params = [], array $headers = []): object
    {
        $response = $this->get($endpoint,  $params, $headers);

        if ($response->failed()) {
            throw new Exception('Erro ao consumir API.');
        }

        $dadosApi = $response->json();

        if (!isset($dadosApi['data'])) {
            throw new Exception('Dados inválidos.');
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