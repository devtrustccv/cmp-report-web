<?php
namespace App\Http\Controllers;

use App\Exceptions\DocumentoNaoEncontradoException;
use App\Http\Helpers\BasicMethods;
use App\Http\Helpers\Enums\TipoLicenciamentoComercialEnum;
use App\Services\AppService;
use Exception;

class LicenciamentoComercialController extends Controller
{
    private AppService $appService;

    public function __construct(AppService $appService)
    {
        $this->appService = $appService;
    }

    /**
     * GET reports/licenciamento-comercial/{certidaoId}
     * O report é escolhido pelo "codigo" devolvido pela API.
     */
    public function gerar(int $certidaoId)
    {
        try {
            $dados = $this->appService->getCertidaoLicenciamento($certidaoId);

            $tipo = TipoLicenciamentoComercialEnum::fromCodigo($dados->codigo);

            if (!$tipo) {
                throw new Exception('Código de declaração não reconhecido: ' . ($dados->codigo ?? '(vazio)'));
            }

            return BasicMethods::generateReport(
                $tipo->view(),
                [
                    'dados' => $dados,
                    'tipo' => $tipo,
                    'isVerificacao' => 1,
                ],
                $tipo->fileName() . '_' . $certidaoId . '.pdf'
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
