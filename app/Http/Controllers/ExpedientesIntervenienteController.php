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
        // Um único render; o "Pág. X de Y" é escrito pelo dompdf em cada página
        // com {PAGE_NUM}/{PAGE_COUNT}, sem precisar de um render prévio para contar as páginas.
        $pdf = Pdf::loadView($view, $dados)->setPaper('A4', $orientacao);
        $pdf->render();

        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        $fonte = $dompdf->getFontMetrics()->getFont('DejaVu Sans');
        $tamanho = 7.5; // 10px
        $texto = 'Pág. {PAGE_NUM} de {PAGE_COUNT}';
        $largura = $dompdf->getFontMetrics()->getTextWidth('Pág. 99 de 99', $fonte, $tamanho);

        $canvas->page_text(
            ($canvas->get_width() - $largura) / 2,
            $canvas->get_height() - 36,
            $texto,
            $fonte,
            $tamanho
        );

        return $pdf->stream($filename);
    }
}
