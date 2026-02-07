<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use App\Http\Utils;
use App\Http\QrCodeService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class IupRemForoController extends Controller
{
   private QrCodeService $qrService;

    public function __construct(QrCodeService $qrService)
    {
        $this->qrService = $qrService;
    }

    public function gerarPdf($id)
    {

        $urlWeb = config('services.global.url_web');

        $link = $urlWeb.'/'.$id;
     //   $qrcode_base64 = $this->qrService->gerarBase64($link);
        $titulo= 'IMPOSTO ÚNICO SOBRE O PATRIMONIO';
        
        $dados=null;
         return Pdf::loadView('iupremforo', [
                'dados' => $dados,
                'titulo' => $titulo,
                'qrcode_base64' => null, // $qrcode_base64,
                'tipo' =>  'IUPREMFORO'
            ])
            ->setPaper('A4')
            ->stream('iupremforo.pdf');
    
    }
}