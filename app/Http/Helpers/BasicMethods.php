<?php
namespace App\Http\Helpers;
use Barryvdh\DomPDF\Facade\Pdf;

class BasicMethods{
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
        array $data,
        ## object $dados,
        ## string $tipo,
        ##  ?string $qrcode = null,
      string $filename
    ) {
        return Pdf::loadView($view, $data)
        ->setPaper('A4', 'portrait')
        ->stream($filename);
    }
}
