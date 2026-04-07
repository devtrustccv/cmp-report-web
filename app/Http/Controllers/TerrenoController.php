<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use App\Models\TerrenoDto;
use App\Http\Utils;
use App\Http\QrCodeService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class TerrenoController extends Controller
{
    private QrCodeService $qrService;

    public function __construct(QrCodeService $qrService)
    {
        $this->qrService = $qrService;
    }


    public function gerarPdf($id)
    {
        $baseUrl = config('services.compra_venda.base_url');
        $token   = config('services.compra_venda.token');
        $urlWeb = config('services.global.url_web') . '/iup-terreno';

        $link = $urlWeb.'/'.$id;
        $qrcode_base64 = $this->qrService->gerarBase64($link);

        $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ])->get("{$baseUrl}/iup-terreno/{$id}");

        if ($response->failed()) {
            abort(404, "Documento não encontrado na API");
        }

        $dadosApi = $response->json();

        
        if (!isset($dadosApi['data'])) {
            abort(500, 'Resposta inválida da API');
        }

       
        $dados = new TerrenoDto($dadosApi['data']);

        return Pdf::loadView('iupterreno', [
                'dados' => $dados,
                'titulo' => 'IMPOSTO ÚNICO SOBRE O PATRIMONIO',
                'qrcode_base64' =>  $qrcode_base64,
                'tipo' => 'IUPTERRENO'
            ])
            ->setPaper([0, 0, 600, 520])
            ->stream('iupterreno.pdf');
    }

}