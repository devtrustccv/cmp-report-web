<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use App\Http\Utils;
use App\Http\QrCodeService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\RemForoDto;


class IupRemForoController extends Controller
{
   private QrCodeService $qrService;

    public function __construct(QrCodeService $qrService)
    {
        $this->qrService = $qrService;
    }

    public function gerarPdf($id)
    {
        try{

            $urlWeb = config('services.global.url_web').'/iupremforo';
            $baseUrl = config('services.compra_venda.base_url');
            $token   = config('services.compra_venda.token');

            $link = $urlWeb.'/'.$id;
            $qrcode_base64 = $this->qrService->gerarBase64($link);

            $response = Http::withoutVerifying()->withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Accept'        => 'application/json',
                ])->get("{$baseUrl}/iup-remicao-foro/{$id}");

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

        
            $dados = new RemForoDto($dadosApi['data']);
            
            return Pdf::loadView('iupremforo', [
                    'dados' => $dados,
                    'titulo' => $dados->titulo,
                    'qrcode_base64' =>  $qrcode_base64,
                    'tipo' =>  'IUPREMFORO'
                ])
                ->setPaper([0, 0, 600, 520])
                ->stream('iupremforo.pdf');

        } catch (\Throwable $e) {

            // Aqui entra a pagina de erro
            return response()->view('errors.generic', [
                    'message' => $e->getMessage()
            ], 500);
                
        }
        
    
    }
}