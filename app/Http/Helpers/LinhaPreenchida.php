<?php

namespace App\Http\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\FontMetrics;

/**
 * Calcula quantos "=" cabem de cada lado de um texto para formar
 * "======= texto =======" com a largura exata da área de texto,
 * usando as mesmas métricas de fonte que o dompdf usa ao desenhar.
 */
class LinhaPreenchida
{
    /** Largura útil da página A4 em pt (595.28pt - margens laterais 2 x 60px = 2 x 45pt) */
    public const LARGURA_PT = 505.28;

    private const FONTES = [
        'times'   => 'times',
        'courier' => 'courier',
        'arial'   => 'helvetica',
    ];

    private static ?FontMetrics $metrics = null;

    /**
     * @return array{0: string, 1: string} [lado esquerdo, lado direito]
     */
    public static function lados(
        string $textoHtml,
        string $fonte = 'arial',
        string $tamanho = '18px',
        bool $italico = false,
        float $larguraPt = self::LARGURA_PT
    ): array {
        $fm = self::metrics();

        $familia = self::FONTES[$fonte] ?? $fonte;
        $estilo  = $italico ? 'italic' : 'normal';
        $font    = $fm->getFont($familia, $estilo) ?? $fm->getFont('helvetica', 'normal');
        $fontB   = $fm->getFont($familia, $italico ? 'bold_italic' : 'bold') ?? $font;
        $sizePt  = self::emPt($tamanho);

        // Mede o texto (partes em <strong>/<b> medidas com a fonte a negrito)
        $larguraTexto = 0.0;
        $partes = preg_split('#(<(?:strong|b)\b[^>]*>.*?</(?:strong|b)>)#si', $textoHtml, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        foreach ($partes as $parte) {
            $negrito = (bool) preg_match('#^<(strong|b)\b#i', $parte);
            $txt = html_entity_decode(strip_tags($parte), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $txt = preg_replace('/\s+/u', ' ', $txt);
            $larguraTexto += $fm->getTextWidth($txt, $negrito ? $fontB : $font, $sizePt);
        }

        $larguraTexto = $larguraTexto + 2 * $fm->getTextWidth(' ', $font, $sizePt);
        $larguraIgual = $fm->getTextWidth('=', $font, $sizePt);

        // floor() garante que "=== texto ===" nunca passa a largura útil
        $n = (int) floor((($larguraPt - $larguraTexto) / 2) / $larguraIgual);
        $n = max(0, $n);

        $lado = str_repeat('=', $n);

        return [$lado, $lado];
    }

    private static function metrics(): FontMetrics
    {
        return self::$metrics ??= Pdf::getDomPDF()->getFontMetrics();
    }

    private static function emPt(string $tamanho): float
    {
        $v = (float) $tamanho;

        return match (true) {
            str_ends_with($tamanho, 'pt') => $v,
            default => $v * 0.75, // px -> pt
        };
    }
}
