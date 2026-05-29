<?php
namespace App;
use Barryvdh\DomPDF\Facade\Pdf;

class Utils{
    public static function renderPdf(
        string $view,
        array $data,
        string $filename,
        array $paper = [0, 0, 600, 520]
    ) {
        return Pdf::loadView($view, $data)
            ->setPaper($paper)
            ->stream($filename);
    }

    public static function generateReport(
        string $view,
        object $dados,
        string $tipo,
        string $filename,
        ?string $qrcode = null
    ) {
        return Pdf::loadView($view, [
            'dados' => $dados,
            'titulo' => $dados->titulo ?? null,
            'qrcode_base64' => $qrcode,
            'tipo' => $tipo,
        ])
        ->setPaper('A4', 'portrait')
        ->stream($filename);
    }
}
