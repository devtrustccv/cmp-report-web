<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use App\Models\CertidaoMatricialDto;
use App\Http\Utils;
use App\Http\QrCodeService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class CertidaoMatricialController extends Controller
{
    private QrCodeService $qrService;

    public function __construct(QrCodeService $qrService)
    {
        $this->qrService = $qrService;
    }
   
    public function gerarPdf($id){

        $baseUrl = config('services.global.url_api');
        $urlWeb = config('services.global.url_web') . '/reports/certidao-matricial';

        $link = $urlWeb.'/'.$id;
        $qrcode_base64 = $this->qrService->gerarBase64($link);

        $response = Http::withoutVerifying()->withHeaders([
                    //'Authorization' => 'Bearer ' . $token,
                    'Accept'        => 'application/json',
                ])->get("{$baseUrl}/certidao_matricial/{$id}");

        if ($response->failed()) {
                return response()->view('errors.generic', [
                        'message' => $e->getMessage()
                ], 500);
        }

        $dadosApi = $response->json();

         

         if (!isset($dadosApi['data'])) {
                 return response()->view('errors.generic', [
                        'message' => $e->getMessage()
            ], 500);
        }


        $dados = new CertidaoMatricialDto($dadosApi['data']);


        return Pdf::loadView('certidao_matricial', [
                            'dados' => $dados,
                            'qrcode_base64' => $qrcode_base64
                        ])
                        ->setPaper('A4', 'portrait')
                        ->stream('iupcompra.pdf');
    }

}