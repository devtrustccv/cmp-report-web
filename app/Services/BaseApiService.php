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

    protected function get(string $endpoint, array $params = [], array $headers = []): Response
    {   
        try{
             
            return Http::withoutVerifying()
                ->timeout(30)
                 ->withHeaders(
                    $headers //['X-API-TOKEN' => 'TOKEN_REPORT_456']
                 )
                ->acceptJson()
                ->get($this->baseUrl . '/' . ltrim($endpoint, '/'), $params);

            } catch (Exception $e) {

                 throw new Exception(
                    'O serviço de documentos encontra-se temporariamente indisponível.'
                );
        }
    }
}