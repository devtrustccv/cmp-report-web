<?php
namespace App\Http\Controllers;


use App\Exceptions\DocumentoNaoEncontradoException;
use App\Http\Helpers\Enums\TipoRelatorioEnum;
use App\Http\Helpers\QrCodeHelper;
use App\Services\AppService;
use App\Http\Helpers\BasicMethods;
use App\Services\UrlCryptoService;
use Exception;


class CertidaoMatricialController extends Controller
{
    private UrlCryptoService $cryptoService;
    private AppService $appService;


    public function __construct(UrlCryptoService $cryptoService, AppService $appService)
    {
        $this->cryptoService = $cryptoService;
        $this->appService = $appService;
    }
   
    public function gerarCertidaoMatricial($params){
        try {

            $values = $this->cryptoService->decrypt($params);

            $id = (int) ($values['id'] ?? 0);
            
            $isVerificacao = (int) ($values['verificacao'] ?? 3); 

            $qrcode_base64 = QrCodeHelper::generateReportQrCode(
                'reports/certidao-matricial',
                $id,
                true
            );

            // SERVICE
            $dados = $this->appService->getDadosCertidaoMatricial($id);
            

            $estado = $dados->estado ?? null;

            $isCertificado = $estado === 'FIM';

            $tipo = TipoRelatorioEnum::CERTIDAO_MATRICIAL;

            return BasicMethods::generateReport("duc.".($tipo->view()),
                            [
                                'dados' => $dados,
                                'titulo' => $dados->titulo ?? null,
                                'qrcode_base64' => $qrcode_base64,
                                'tipo' => $tipo,
                                'estado' => $estado,
                                'isVerificacao' => $isVerificacao,
                                'isCertificado' => $isCertificado,
                            ],
                            $tipo->fileName() . '.pdf');

         } catch (DocumentoNaoEncontradoException $e) {

            return response()->view('errors.documento-nao-encontrado', [], 404);

         } catch (Exception $e) {

            return response()->view('errors.500', [
                'message' => $e->getMessage()
            ], 500);
        }
    }

}