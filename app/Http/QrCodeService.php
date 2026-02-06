<?php

namespace App\Http;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeService
{
    /**
     * Gera QR Code em Base64 a partir de um link
     */
    public function gerarBase64(string $link): string
    {
        // gera PNG binário
        $png = QrCode::format('png')->size(80)->generate($link);
        // converte para base64 e retorna
        return base64_encode($png);
    }

    /**
     * Gera QR Code em SVG
     */
    public function gerarSvg(string $link): string
    {
        return QrCode::format('svg')->size(200)->generate($link);
    }

}
