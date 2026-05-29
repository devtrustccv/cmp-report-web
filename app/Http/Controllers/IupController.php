<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Enums\TipoRelatorioEnum;
use App\Http\Helpers\QrCodeHelper;
use App\Services\AppService;
use App\Utils;

class IupController extends Controller
{
    public function __construct(
        private AppService $appService
    ) {}

    public function doacao(int $id)
    {
        return $this->gerar($id, TipoRelatorioEnum::IUPDOACAO, 'getDoacao');
    }

    public function remForo(int $id)
    {
        return $this->gerar($id, TipoRelatorioEnum::IUPREMFORO, 'getRemForo');
    }

    public function partilha(int $id)
    {
        return $this->gerar($id, TipoRelatorioEnum::IUPPARTILHA, 'getPartilha');
    }

    public function terreno(int $id)
    {
        return $this->gerar($id, TipoRelatorioEnum::IUPTERRENO, 'getTerreno');
    }

    public function compraVenda(int $id)
    {
        return $this->gerar($id, TipoRelatorioEnum::IUPCOMPRA, 'getCompraVenda');
    }

    private function gerar(
        int $id,
        TipoRelatorioEnum $tipo,
        string $method
    ) {
        try {

            $qrcode_base64 = QrCodeHelper::generateReportQrCode(
                $tipo->view(),
                $id
            );

            $dados = $this->appService->{$method}($id);

            return Utils::renderPdf(
                "duc".$tipo->view(),
                [
                    'dados' => $dados,
                    'titulo' => $dados->titulo,
                    'qrcode_base64' => $qrcode_base64,
                    'tipo' => $tipo->view()
                ],
                "{$tipo->fileName()}.pdf"
            );

        } catch (\Throwable $e) {

            return response()->view('errors.generic', [
                'message' => $e->getMessage()
            ], 500);

        }
    }
}