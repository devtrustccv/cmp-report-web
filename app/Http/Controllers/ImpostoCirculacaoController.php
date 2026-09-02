<?php

namespace App\Http\Controllers;

use App\Exceptions\DocumentoNaoEncontradoException;
use App\Http\Helpers\BasicMethods;
use App\Http\Helpers\QrCodeHelper;
use App\Models\ImpostoCirculacaoDto;
use App\Services\AppService;
use App\Services\UrlCryptoService;
use Exception;

class ImpostoCirculacaoController extends Controller
{
    private UrlCryptoService $cryptoService;
    private AppService $appService;

    public function __construct(UrlCryptoService $cryptoService, AppService $appService)
    {
        $this->cryptoService = $cryptoService;
        $this->appService = $appService;
    }

    public function gerar(string $token)
    {
        try {

          //  $values = $this->cryptoService->decrypt($token);

            $id = 1; //(int) ($values['id'] ?? 0);

            $isVerificacao = 3; //(int) ($values['verificacao'] ?? 3);

            $qrcode_base64 = QrCodeHelper::generateReportQrCode(
                'reports/imposto-circulacao',
                $id,
                true
            );

            $dados = new ImpostoCirculacaoDto([
                'numero' => '1',
                'especie' => 'AUTOMOVEL',
                'cilindrada' => '1300-1750',
                'matricula' => 'ST-DF-38',
                'anoMatricula' => '2026',
                'marcaCategoria' => 'AUTOMOVEL',
                'marca' => 'Peugeot',
                'proprietarioNome' => 'RENT A CAR VERDE LDA',
                'proprietarioResidencia' => '',
                'ano' => '2026',
                'disticoSerie' => 'C',
                'disticoNumero' => '1',
                'taxaValor' => 1800,
                'taxaImpresso' => 0,
                'taxaJuros' => 0,
                'taxaTotal' => 1800,
                'registoNumero' => '5521250',
                'dataRegisto' => '01/09/2026',
                'cobradoPor' => 'B.U - Carmem Rosa',
                'dataEmissao' => '01-09-2026',
                'referencia' => '5521250',
                'entidade' => '112',
                'codigoBarra' => '00301010000552125018',
            ]);
            /*$dados = $this->appService->getImpostoCirculacao($id);*/

            return BasicMethods::generateReport(
                'imposto_circulacao.registo_distico',
                [
                    'dados' => $dados,
                    'qrcode_base64' => $qrcode_base64,
                    'isVerificacao' => $isVerificacao,
                ],
                'declaracao_imposto_circulacao.pdf',
                'portrait'
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
