<?php

namespace App\Services;

use App\Models\CertidaoMatricialDto;
use Exception;


class AppService extends BaseApiService
{
   
    public function getDadosCertidaoMatricial(int $id): CertidaoMatricialDto
    {
        $response = $this->get("/certidao_matricial/{$id}");

        if ($response->failed()) {
            throw new Exception('Erro ao consumir API.');
        }

        $dadosApi = $response->json();

        if (!isset($dadosApi['data'])) {
            throw new Exception('Dados inválidos.');
        }

        return new CertidaoMatricialDto($dadosApi['data']);
    }
}