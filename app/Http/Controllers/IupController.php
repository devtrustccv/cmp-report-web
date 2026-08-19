<?php

namespace App\Http\Controllers;

use App\Exceptions\DocumentoNaoEncontradoException;
use App\Http\Helpers\Enums\TipoRelatorioEnum;
use App\Http\Helpers\BasicMethods;
use App\Http\Helpers\QrCodeHelper;
use App\Services\AppService;
use App\Services\UrlCryptoService;

class IupController extends Controller
{
    public function __construct(
        private AppService $appService,
        private UrlCryptoService $cryptoService
    ) {}

    public function doacao(string $params)
    {
        return $this->gerar($params, TipoRelatorioEnum::IUPDOACAO, 'getDoacao');
    }

    public function remForo(string $params)
    {
        return $this->gerar($params, TipoRelatorioEnum::IUPREMFORO, 'getRemForo');
    }

    public function partilha(string $params)
    {
        return $this->gerar($params, TipoRelatorioEnum::IUPPARTILHA, 'getPartilha');
    }

    public function sucessorio(string $params)
    {
        return $this->gerar($params, TipoRelatorioEnum::IUPSUCESSORIO, 'getSucessorio');
    }

    public function terreno(string $params)
    {
        return $this->gerar($params, TipoRelatorioEnum::IUPTERRENO, 'getTerreno');
    }

    public function compraVenda(string $params)
    {
        return $this->gerar($params, TipoRelatorioEnum::IUPCOMPRA, 'getCompraVenda');
        
    }

    private function gerar(
        string $params,
        TipoRelatorioEnum $tipo,
        string $method
    ) {
        try {

            $values = $this->cryptoService->decrypt($params);

            $id = (int) ($values['id'] ?? 0);
            $isVerificacao = (int) ($values['verificacao'] ?? 3); 

            $dados = $this->appService->{$method}($id);


            $estado = $dados->estado ?? null;

            $isCertificado = $estado === 'FIM';

            $qrcode_base64 = QrCodeHelper::generateReportQrCode(
                $tipo->view(),
                $id,
                true
            );

            return BasicMethods::renderPdf(
                'duc.' . $tipo->view(),
                [
                    'dados' => $dados,
                    'titulo' => $dados->titulo,
                    'qrcode_base64' => $qrcode_base64,
                    'tipo' => $tipo->code(),
                    'estado' => $estado,
                    'isVerificacao' => $isVerificacao,
                    'isCertificado' => $isCertificado,
                ],
                $tipo->fileName() . '.pdf'
            );

        } catch (DocumentoNaoEncontradoException $e) {
            return response()->view('errors.documento-nao-encontrado', [], 404);
        } catch (\Throwable $e) {
            return response()->view('errors.500', [
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function abrirPorToken(string $token, UrlCryptoService $crypto)
    {
        $params = $crypto->decrypt($token);

        $id = (int) ($params['id'] ?? 0);
        $tipo = $params['tipo'] ?? null;
        $verificacao = ($params['verificacao'] ?? null) === '1';

        if (!$id || !$tipo) {
            abort(400, 'Parâmetros inválidos.');
        }

        return [
            'id' => $id,
            'tipo' => $tipo,
            'verificacao' => $verificacao,
        ];
    }
}