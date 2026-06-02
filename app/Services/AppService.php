<?php

namespace App\Services;

use App\Models\AssinaturaDto;
use App\Models\CertidaoMatricialDto;
use App\Models\CompraVenda;
use App\Models\DoacaoDto;
use App\Models\PartilhaDto;
use App\Models\RemForoDto;
use App\Models\TerrenoDto;
use Exception;


class AppService extends BaseApiService
{

    private function getDto(string $endpoint, string $dtoClass , array $params = []): object
    {
        $response = $this->get($endpoint,  $params);

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
            "/certidao_matricial/{$id}",
            CertidaoMatricialDto::class
        );
    }

    public function getCompraVenda(int $id): CompraVenda
    {
        return $this->getDto(
            "/compra-venda/{$id}",
            CompraVenda::class
        );
    }

    public function getDoacao(int $id): DoacaoDto
    {
        return $this->getDto(
            "/iup-doacao/{$id}",
            DoacaoDto::class
        );
    }

    public function getPartilha(int $id): PartilhaDto
    {
        return $this->getDto(
            "/iup-partilha/{$id}",
            PartilhaDto::class
        );
    }

    public function getRemForo(int $id): RemForoDto
    {
        return $this->getDto(
            "/iup-remicao-foro/{$id}",
            RemForoDto::class
        );
    }

    public function getTerreno(int $id): TerrenoDto
    {
        return $this->getDto(
            "/iup-terreno/{$id}",
            TerrenoDto::class
        );
    }

    public function getDocumentData(int $id){
       
        $response = $this->get("/documento/{$id}");

        if ($response->failed()) {
            throw new \Exception('Erro ao obter documento.');
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