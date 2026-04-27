<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use App\Models\CompraVenda;
use App\Http\Utils;
use App\Http\QrCodeService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class CompraVendaController extends Controller
{
    private QrCodeService $qrService;

    public function __construct(QrCodeService $qrService)
    {
        $this->qrService = $qrService;
    }


    public function gerarPdf($id)
    {
        try{

            $baseUrl = config('services.compra_venda.base_url');
            $token   = config('services.compra_venda.token');
            $urlWeb = config('services.global.url_web') . '/compra-venda';

            $link = $urlWeb.'/'.$id;
            $qrcode_base64 = $this->qrService->gerarBase64($link);


            $response = Http::withoutVerifying()->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept'        => 'application/json',
                ])->get("{$baseUrl}/compra-venda/{$id}");

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

        
            $dados = new CompraVenda($dadosApi['data']);

            return Pdf::loadView('iupcompra', [
                    'dados' => $dados,
                    'titulo' => $dados->titulo,
                    'qrcode_base64' => $qrcode_base64,
                    'tipo' => 'IUPCOMPRA'
                ])
                ->setPaper([0, 0, 600, 520])
                ->stream('iupcompra.pdf');

        } catch (\Throwable $e) {

            // Aqui entra a pagina de erro
            return response()->view('errors.generic', [
                    'message' => $e->getMessage()
            ], 500);
                
        }
        
       
    }

}
