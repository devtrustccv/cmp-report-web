<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use App\Models\AssinaturaDto;
use App\Http\Utils;
use Illuminate\Http\Request;


class AtestadoController extends Controller
{

    public function gerarPdf(Request $request)
    {
        
        $tipo       = request('tipo', 'DEFAULT');
        $idProcesso = request('idProcesso', 0);
        $userName   = request('userName', 'guest');
        $email      = request('email', '');

       
        $baseUrl = config('services.global.url_api');
        $token   = config('services.compra_venda.token');
 
        $response = Http::withoutVerifying()->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ])->get("{$baseUrl}/assinatura?userName={$userName}&email={$email}&idProcesso={$idProcesso}");

           
        

        if ($response->failed()) {
            abort(404, "Documento não encontrado na API");
        }
       
        $dadosApi = $response->json();
        
        if (!isset($dadosApi['data'])) {
            abort(500, 'Resposta inválida da API');
        }
       
        $dadosAssinatura = new AssinaturaDto($dadosApi['data']);

        switch ($dadosAssinatura->tipoPedido) {
            case 'ATESTADO DE AGREGADO FAMILIAR':
                return Pdf::loadView('atestado.agregado_familiar', [
                    'assinatura' => $dadosAssinatura
                ])->setPaper('A4')->stream('agregado_familiar.pdf');

            case 'ATESTADO DE RESIDÊNCIA':
                return Pdf::loadView('atestado.residencia', [
                    'assinatura' => $dadosAssinatura
                ])->setPaper('A4')->stream('residencia.pdf');

            case 'ATESTADO DE PROBREZA':
                return Pdf::loadView('atestado.pobreza', [
                    'assinatura' => $dadosAssinatura
                ])->setPaper('A4')->stream('pobreza.pdf');
        }
                
    }
}