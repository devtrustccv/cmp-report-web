<?php
namespace App\Http\Controllers;

use App\Exceptions\DocumentoNaoEncontradoException;
use App\Http\Helpers\BasicMethods;
use App\Http\Helpers\Enums\TipoDeclaracaoEnum;
use App\Http\Helpers\QrCodeHelper;
use App\Services\AppService;
use App\Services\UrlCryptoService;
use Exception;

class DeclaracaoController extends Controller
{
    private UrlCryptoService $cryptoService;
    private AppService $appService;

    public function __construct(UrlCryptoService $cryptoService, AppService $appService)
    {
        $this->cryptoService = $cryptoService;
        $this->appService = $appService;
    }

    public function gerar(string $tipo, string $token)
    {
        try {

            $tipoDeclaracao = TipoDeclaracaoEnum::fromSlug($tipo);

            if (!$tipoDeclaracao) {
                abort(404, 'Tipo de declaração não reconhecido: ' . $tipo);
            }

          //  $values = $this->cryptoService->decrypt($token);

            $id = 1; //(int) ($values['id'] ?? 0);

            $isVerificacao = 3; //(int) ($values['verificacao'] ?? 3);

            $qrcode_base64 = QrCodeHelper::generateReportQrCode(
                'reports/declaracao/' . $tipoDeclaracao->slug(),
                $id,
                true
            );

            $dados = null;
            /*match ($tipoDeclaracao) {
                TipoDeclaracaoEnum::PREDIOS_REGISTADOS => $this->appService->getDeclaracaoPrediosRegistados($id),
            };*/

            return BasicMethods::generateReport(
                $tipoDeclaracao->view(),
                [
                    'dados' => $dados,
                    'tipo' => $tipoDeclaracao,
                    'qrcode_base64' => $qrcode_base64,
                    'isVerificacao' => $isVerificacao,
                ],
                $tipoDeclaracao->fileName() . '.pdf'
            );

        } catch (DocumentoNaoEncontradoException $e) {

            return response()->view('errors.documento-nao-encontrado', [], 404);

        } catch (Exception $e) {

            return response()->view('errors.500', [
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
