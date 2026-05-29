<?php
namespace App\Http\Controllers;

use App\Http\Helpers\Enums\TipoAtestadoEnum;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\AppService;
use Illuminate\Http\Request;

class AtestadoController extends Controller
{

    private AppService $appService;

    public function __construct(AppService $appService)
    {
        $this->appService = $appService;
    }

    public function gerarPdf(Request $request)
    {
        
        try{

            $request->validate([
                'idProcesso' => 'required|integer',
                'userName'   => 'required|string',
                'email'      => 'required|email',
            ]);

            $idProcesso = (int) $request->query('idProcesso');
            $userName   = (string) $request->query('userName');
            $email      = (string) $request->query('email');

            $dadosAssinatura = $this->appService->getAtestado($userName, $email, $idProcesso);

            $tipoAtestado = TipoAtestadoEnum::tryFrom(strtoupper($dadosAssinatura->tipoPedido));

            if (!$tipoAtestado) {
                abort(404, 'Tipo de atestado não reconhecido: ' . $dadosAssinatura->tipoPedido);
            }

            return Pdf::loadView($tipoAtestado->view(), [
                    'assinatura' => $dadosAssinatura
                ])->setPaper('A4')->stream($tipoAtestado->fileName());
        

         } catch (\Throwable $e) {

            // Aqui entra a pagina de erro
            return response()->view('errors.generic', [
                    'message' => $e->getMessage()
            ], 500);
                
        }
        
        

                
    }
}