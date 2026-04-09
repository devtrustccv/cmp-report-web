<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class DocumentController extends Controller
{
    public function loadDocument($id)
    {
        try {
            $baseUrl = config('services.global.url_api');
            $token   = config('services.global.token');

            $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ])->get("{$baseUrl}/documento/{$id}");

            if ($response->failed()) {
                return $this->renderGenericError('Documento não encontrado.', 404);
            }

            $dadosApi = $response->json();

            $base64Pdf = $dadosApi['data']['blobContent'] ?? null;
            $mimeType  = $dadosApi['data']['mimeType'] ?? 'application/pdf';

            return $this->renderPdfFromBase64($base64Pdf, $mimeType);

        } catch (\Throwable $e) {
            return $this->renderGenericError('Ocorreu um erro interno ao carregar o documento.', 500);
        }
    }
}