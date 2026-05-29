<?php

namespace App\Http\Helpers;

use App\Http\QrCodeService;

class QrCodeHelper
{
    public static function generateReportQrCode(
        string $path,
        int|string $id
    ): string {

        $url = rtrim(
            config('services.global.url_web'),
            '/'
        );

        $link = $url . '/' . trim($path, '/') . '/' . $id;

        return app(QrCodeService::class)
            ->gerarBase64($link);
    }
}