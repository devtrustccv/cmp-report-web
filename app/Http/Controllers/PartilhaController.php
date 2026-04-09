<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use App\Models\PartilhaDto;
use App\Http\Utils;
use App\Http\QrCodeService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class PartilhaController extends Controller
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
            $urlWeb = config('services.global.url_web') . '/iup-parilha';
    
            $link = $urlWeb.'/'.$id;
            $qrcode_base64 =  $this->qrService->gerarBase64($link);

            $response = Http::withoutVerifying()->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept'        => 'application/json',
                ])->get("{$baseUrl}/iup-partilha/{$id}");

            if ($response->failed()) {
               // Aqui entra a pagina de erro
                return response()->view('errors.generic', [
                        'message' => $e->getMessage()
                ], 500);
            }

            $dadosApi = $response->json();
            
            if (!isset($dadosApi['data'])) {
                // Aqui entra a pagina de erro
                return response()->view('errors.generic', [
                        'message' => $e->getMessage()
                ], 500);
            }

        
            $dados = new PartilhaDto($dadosApi['data']);


            return Pdf::loadView('iuppartilha',[
                'qrcode_base64' =>  $qrcode_base64,
                'tipo' => 'IUPPARTILHA',
                'dados' => $dados,
                'titulo' => $dados->titulo
            ])->setPaper([0, 0, 600, 520])
                ->stream('iuppartilha.pdf');

        } catch (\Throwable $e) {

            // Aqui entra a pagina de erro
            return response()->view('errors.generic', [
                    'message' => $e->getMessage()
            ], 500);
                
        }
        
    }

}
