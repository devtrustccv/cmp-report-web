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

        $urlWeb = config('services.global.url_web').'/iup-remicao-foro';
        $baseUrl = config('services.compra_venda.base_url');
        $token   = config('services.compra_venda.token');

        $link = $urlWeb.'/'.$id;
        $qrcode_base64 = null; //$this->qrService->gerarBase64($link);
        $titulo= 'IMPOSTO ÚNICO SOBRE O PATRIMONIO';

        $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ])->get("{$baseUrl}/iup-remicao-foro/{$id}");

        if ($response->failed()) {
            abort(404, "Documento não encontrado na API");
        }

        $dadosApi = $response->json();

        
        if (!isset($dadosApi['data'])) {
            abort(500, 'Resposta inválida da API');
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
    
    }
}