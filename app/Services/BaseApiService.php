<?php

namespace App\Services;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class BaseApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.global.url_api');
    }

    protected function get(string $endpoint, array $params = []): Response
    {   
        try{
             
            return Http::withoutVerifying()
                ->timeout(30)
                ->acceptJson()
                ->get($this->baseUrl . '/' . ltrim($endpoint, '/'), $params);

            } catch (Exception $e) {

                 throw new Exception(
                    'O serviço de documentos encontra-se temporariamente indisponível.'
                );
        }
    }
}