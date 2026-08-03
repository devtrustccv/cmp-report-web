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

    protected function put(string $endpoint, array $data = [], array $headers = []): Response
    {
        try{

            return Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders($headers)
                ->acceptJson()
                ->put($this->baseUrl . '/' . ltrim($endpoint, '/'), $data);

            } catch (Exception $e) {

                 throw new Exception(
                    'O serviço de documentos encontra-se temporariamente indisponível.'
                );
        }
    }

    protected function postFile(
        string $endpoint,
        string $fieldName,
        string $contents,
        string $filename,
        string $mimeType = 'application/pdf',
        array $headers = []
    ): Response
    {
        try{

            return Http::withoutVerifying()
                ->timeout(30)
                ->withHeaders($headers)
                ->acceptJson()
                ->attach($fieldName, $contents, $filename, ['Content-Type' => $mimeType])
                ->post($this->baseUrl . '/' . ltrim($endpoint, '/'));

            } catch (Exception $e) {

                 throw new Exception(
                    'O serviço de documentos encontra-se temporariamente indisponível.'
                );
        }
    }
}