<?php

namespace App\Http\Controllers;

use App\Exceptions\DocumentoNaoEncontradoException;
use App\Http\Helpers\BasicMethods;
use App\Services\AppService;
use App\Services\UrlCryptoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;

class ExpedientesIntervenienteController extends Controller
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

            $values = $this->cryptoService->decrypt($token);

            $dataInicio = $values['dataInicio'] ?? Carbon::now()->startOfMonth()->toDateString();
            $dataFim = $values['dataFim'] ?? Carbon::now()->toDateString();
            $utilizador = $values['utilizador'] ?? '';
            $faseId = $values['faseId'] ?? null;
            $cmintervId = $values['cmintervId'] ?? null;

            $expedientes = $this->appService->getExpedientesEncaminhadosPorInterveniente(array_filter([
                'dataInicio' => $dataInicio,
                'dataFim' => $dataFim,
                'faseId' => $faseId,
                'cmintervId' => $cmintervId,
            ], fn ($valor) => $valor !== null && $valor !== ''));

            $grupos = collect($expedientes)->groupBy('dtFase');

            $dados = [
                'grupos' => $grupos,
                'dataInicio' => $dataInicio,
                'dataFim' => $dataFim,
                'utilizador' => $utilizador,
                'dataEmissao' => Carbon::now()->translatedFormat('d \d\e F \d\e Y'),
            ];

            return $this->gerarComTotalPaginas(
                'expedientes_interveniente.lista',
                $dados,
                'lista_expedientes_encaminhados_por_interveniente.pdf',
                'landscape'
            );

        } catch (DocumentoNaoEncontradoException $e) {

            return response()->view('errors.documento-nao-encontrado', [], 404);

        } catch (Exception $e) {

            return response()->view('errors.500', [
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lista de Expedientes (API reports/lista-pedido), agrupada por data do pedido e assunto.
     */
    public function listaPedido(string $token)
    {
        try {

            $values = $this->cryptoService->decrypt($token);

            $dataInicio = $values['dataInicio'] ?? Carbon::now()->startOfMonth()->toDateString();
            $dataFim = $values['dataFim'] ?? Carbon::now()->toDateString();

            $report = $this->appService->getListaPedido(array_filter([
                'dataInicio' => $dataInicio,
                'dataFim' => $dataFim,
                'tpPedidoId' => $values['tpPedidoId'] ?? null,
                'nmIntervAntId' => $values['nmIntervAntId']  ?? null,
                'utilizadorId' => $values['utilizadorId'] ?? null,
            ], fn ($valor) => $valor !== null && $valor !== ''));

            $dados = [
                'grupos' => collect($report['pedidos'])->groupBy('dtPedido'),
                'dataInicio' => $dataInicio,
                'dataFim' => $dataFim,
                'utilizador' => $report['nmUtilizador'] ?? ($values['utilizador'] ?? ''),
                'dataEmissao' => $report['dtActual'] ?? Carbon::now()->translatedFormat('d \d\e F \d\e Y'),
            ];

            return $this->gerarComTotalPaginas(
                'expedientes_interveniente.lista_pedido',
                $dados,
                'lista_expedientes.pdf',
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

    private function gerarComTotalPaginas(string $view, array $dados, string $filename, string $orientacao)
    {
        // dompdf não tem contador de total de páginas nativo: faz-se um render prévio
        // só para descobrir o total e injectá-lo no rodapé do render final.
        $rascunho = Pdf::loadView($view, $dados)->setPaper('A4', $orientacao);
        $rascunho->render();
        $dados['totalPaginas'] = $rascunho->getDomPDF()->getCanvas()->get_page_count();

        return BasicMethods::generateReport($view, $dados, $filename, $orientacao);
    }
}
