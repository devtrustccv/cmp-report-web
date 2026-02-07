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
        $baseUrl = config('services.compra_venda.base_url');
        $token   = config('services.compra_venda.token');
        $urlWeb = config('services.global.url_web');

        $link = $urlWeb.'/'.$id;
        $qrcode_base64 = $this->qrService->gerarBase64($link);

        $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ])->get("{$baseUrl}/compra-venda/{$id}");

        if ($response->failed()) {
            abort(404, "Documento não encontrado na API");
        }

        $dadosApi = $response->json();

        
        if (!isset($dadosApi['data'])) {
            abort(500, 'Resposta inválida da API');
        }

       
        $dados = new CompraVenda($dadosApi['data']);
        
        $titulo = 'IMPOSTO SOBRE A TRANSMISSÃO DE IMÓVEIS (ITI)';
        if($dados->anoEscritura < 2026)
             $titulo = 'IMPOSTO SOBRE O PATRIMONIO';

        return Pdf::loadView('iupcompra', [
                'dados' => $dados,
                'titulo' => $titulo,
                'qrcode_base64' => $qrcode_base64,
                'tipo' => 'IUPCOMPRA'
            ])
            ->setPaper('A4')
            ->stream('iupcompra.pdf');
    }

}
