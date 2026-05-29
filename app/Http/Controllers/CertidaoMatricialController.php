<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\QrCodeService;
use App\Services\AppService;
use Exception;


class CertidaoMatricialController extends Controller
{
    private QrCodeService $qrService;
    private AppService $appService;


    public function __construct(QrCodeService $qrService, AppService $appService)
    {
        $this->qrService = $qrService;
        $this->appService = $appService;
    }
   
    public function gerarPdf($id){
        try {
            $urlWeb = config('services.global.url_web') . '/reports/certidao-matricial';
            $link = $urlWeb.'/'.$id;
            $qrcode_base64 = $this->qrService->gerarBase64($link);
            // SERVICE
            $dados = $this->appService->getDadosCertidaoMatricial($id);

            return Pdf::loadView('certidao_matricial', [
                                'dados' => $dados,
                                'qrcode_base64' => $qrcode_base64
                            ])
                            ->setPaper('A4', 'portrait')
                            ->stream('iupcompra.pdf');

         } catch (Exception $e) {

            return response()->view('errors.generic', [
                'message' => $e->getMessage()
            ], 500);
        }
    }

}