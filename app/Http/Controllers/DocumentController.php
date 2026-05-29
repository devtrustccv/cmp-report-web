<?php

namespace App\Http\Controllers;

use App\Services\AppService;
use Illuminate\Support\Facades\Http;

class DocumentController extends Controller
{
    private AppService $appService;

    public function __construct(AppService $appService)
    {
        $this->appService = $appService;
    }

    public function loadDocument($id)
    {
        try {
           
            $dadosApi = $this->appService->getDocumentData($id);
            $base64Pdf = $dadosApi['data']['blobContent'] ?? null;
            $mimeType  = $dadosApi['data']['mimeType'] ?? 'application/pdf';
            return $this->renderPdfFromBase64($base64Pdf, $mimeType);

        } catch (\Throwable $e) {
            return $this->renderGenericError('Ocorreu um erro interno ao carregar o documento.', 500);
        }
    }
}