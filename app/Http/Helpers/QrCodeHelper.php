<?php

namespace App\Http\Helpers;

use App\Http\QrCodeService;
use App\Services\UrlCryptoService;

class QrCodeHelper
{
    public static function generateReportQrCode(
        string $path,
        int|string $id,
        bool $isVerificacao = false
    ): string {
        $params = [
            'id' => $id,
        ];

        if ($isVerificacao) {
            $params['verificacao'] = 2;
        }

        $queryString = http_build_query($params);

        $token = app(UrlCryptoService::class)->encrypt($queryString);

        $url = rtrim(config('services.global.url_web'), '/');

        $link = $url . '/' . trim($path, '/') . '/' . $token;

        return app(QrCodeService::class)->gerarBase64($link);
    }


    public static function generateReportQrCodeDocumentPublic(
        string $path,
        int|string $id
    ): string {
    
        $url = rtrim(config('services.global.url_web'), '/');

        $link = $url . '/' . trim($path, '/') . '/' . $id;

        return app(QrCodeService::class)->gerarBase64($link);
    }
}