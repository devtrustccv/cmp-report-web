<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;


class CertidaoMatricialController extends Controller
{
   
    public function gerarPdf(){
        return Pdf::loadView('certidao_matricial', [
                            'dados' => null,
                            'titulo' => null,
                            'qrcode_base64' => null,
                            'tipo' => 'IUPCOMPRA'
                        ])
                        ->setPaper('A4', 'portrait')
                        ->stream('iupcompra.pdf');
    }

}