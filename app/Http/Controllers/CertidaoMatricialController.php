<?php
namespace App\Http\Controllers;

use App\Enums\TipoRelatorioEnum;
use App\Helpers\QrCodeHelper;
use App\Http\QrCodeService;
use App\Services\AppService;
use App\Utils;
use Exception;


class CertidaoMatricialController extends Controller
{
    private QrCodeService $qrService;
    private AppService $appService;


    public function __construct(QrCodeService $qrService, AppService $appService)
    {
        $this->qrService = $qrService;
        $this->appService = $appService;
    }
   
    public function gerarPdf($id){
        try {

            $qrcode_base64 = QrCodeHelper::generateReportQrCode(
                'reports/certidao-matricial',
                $id
            );

            // SERVICE
            $dados = $this->appService->getDadosCertidaoMatricial($id);

            return Utils::generateReport(TipoRelatorioEnum::CERTIDAO_MATRICIAL->view(),
                            $dados,
                            "",
                            "",
                            $qrcode_base64);

         } catch (Exception $e) {

            return response()->view('errors.generic', [
                'message' => $e->getMessage()
            ], 500);
        }
    }

}