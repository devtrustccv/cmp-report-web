<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function renderGenericError(
        string $message = 'Ocorreu um erro ao processar o documento.',
        int $status = 500
    ) {
        return response()->view('errors.generic', [
            'message' => $message
        ], $status);
    }

    protected function renderPdfFromBase64(?string $base64Pdf, string $mimeType = 'application/pdf')
    {
        if (!$base64Pdf) {
            return $this->renderGenericError('Conteúdo do documento não encontrado.', 404);
        }

        $pdfBinary = base64_decode($base64Pdf, true);

        if ($pdfBinary === false) {
            return $this->renderGenericError('Erro ao decodificar o documento PDF.', 500);
        }

        return response($pdfBinary, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="documento.pdf"');
    }
}