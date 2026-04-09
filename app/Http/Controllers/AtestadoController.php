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
        
        try{

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
        
            $dadosAssinatura = new AssinaturaDto($dadosApi['data']);

            $tipo = trim(strtoupper($dadosAssinatura->tipoPedido));
            
            if ($tipo === 'ATESTADO DE AGREGADO FAMILIAR') {
                return Pdf::loadView('atestado.agregado_familiar', [
                    'assinatura' => $dadosAssinatura
                ])->setPaper('A4')->stream('agregado_familiar.pdf');

            } elseif ($tipo === 'ATESTADO DE RESIDÊNCIA') {
                return Pdf::loadView('atestado.residencia', [
                    'assinatura' => $dadosAssinatura
                ])->setPaper('A4')->stream('residencia.pdf');

            } elseif ($tipo === 'ATESTADO DE POBREZA') {
                return Pdf::loadView('atestado.pobreza', [
                    'assinatura' => $dadosAssinatura
                ])->setPaper('A4')->stream('pobreza.pdf');

            } else {
                abort(404, 'Tipo de atestado não reconhecido: ' . $dadosAssinatura->tipoPedido);
            }

         } catch (\Throwable $e) {

            // Aqui entra a pagina de erro
            return response()->view('errors.generic', [
                    'message' => $e->getMessage()
            ], 500);
                
        }
        
        

                
    }
}