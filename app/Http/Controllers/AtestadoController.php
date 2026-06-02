<?php
namespace App\Http\Controllers;

use App\Http\Helpers\Enums\TipoAtestadoEnum;
use App\Http\Helpers\QrCodeHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\AppService;
use App\Services\UrlCryptoService;

class AtestadoController extends Controller
{

    private AppService $appService;
    private UrlCryptoService $cryptoService;

    public function __construct(AppService $appService,UrlCryptoService $cryptoService)
    {
        $this->appService = $appService;
        $this->cryptoService = $cryptoService;
    }

    public function gerarPdf($params)
    {
        
        try{

            $values = $this->cryptoService->decrypt($params);

            $idProcesso = (string) ($values['idProcesso'] ?? ""); 
            $userName = (string) ($values['userName'] ?? ""); 
            $email = (string) ($values['email'] ?? ""); 
            $verificacao = (string) ($values['verificacao'] ?? null); 

            $dadosAssinatura = $this->appService->getAtestado($userName, $email, $idProcesso);
           

            $tipoAtestado = TipoAtestadoEnum::tryFrom(strtoupper($dadosAssinatura->tipoPedido));

           

            if (!$tipoAtestado) {
                abort(404, 'Tipo de atestado não reconhecido: ' . $dadosAssinatura->tipoPedido);
            }

             $qrcode_base64 = QrCodeHelper::generateReportQrCodeDocumentPublic(
                'atestado',
                $idProcesso,
                $userName,
                $email,
                true
            );

            return Pdf::loadView($tipoAtestado->view(), [
                    'assinatura' => $dadosAssinatura,
                    'qrcode_base64' => $qrcode_base64,
                    'verificacao' => $verificacao
                ])->setPaper('A4')->stream($tipoAtestado->fileName());
        

         } catch (\Throwable $e) {

            // Aqui entra a pagina de erro
            return response()->view('errors.500', [
                    'message' => $e->getMessage()
            ], 500);
                
        }
        
        

                
    }
}