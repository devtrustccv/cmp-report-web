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
     * Calcula a linha "=== texto ===" justificada à largura útil.
     *
     * @return array{lado: string, wordSpacing: float}
     *   lado        -> "=" a colocar de cada lado (vazio se o texto não couber numa linha)
     *   wordSpacing -> espaço extra (pt) por cada espaço, para a linha ir exatamente de margem a margem
     */
    public static function calcular(
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
        $textoHtml = trim(preg_replace('/\s+/u', ' ', $textoHtml));
        $larguraTexto = 0.0;
        $espacos = 0;
        $partes = preg_split('#(<(?:strong|b)\b[^>]*>.*?</(?:strong|b)>)#si', $textoHtml, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

        foreach ($partes as $parte) {
            $negrito = (bool) preg_match('#^<(strong|b)\b#i', $parte);
            $txt = html_entity_decode(strip_tags($parte), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $larguraTexto += $fm->getTextWidth($txt, $negrito ? $fontB : $font, $sizePt);
            $espacos += substr_count($txt, ' ');
        }

        $larguraEspaco = $fm->getTextWidth(' ', $font, $sizePt);
        $larguraIgual  = $fm->getTextWidth('=', $font, $sizePt);
        $larguraTexto += 2 * $larguraEspaco; // espaços entre os "=" e o texto
        $espacos += 2;

        // floor() garante que "=== texto ===" nunca passa a largura útil
        $n = max(0, (int) floor((($larguraPt - $larguraTexto) / 2) / $larguraIgual));

        if ($n === 0) {
            return ['lado' => '', 'wordSpacing' => 0.0];
        }

        // O que sobra (menos de 2 "=") é distribuído pelos espaços -> linha justificada.
        // 0.5pt de folga para arredondamentos nunca fazerem a linha quebrar.
        $sobra = $larguraPt - ($larguraTexto + 2 * $n * $larguraIgual) - 0.5;

        return [
            'lado'        => str_repeat('=', $n),
            'wordSpacing' => max(0.0, round($sobra / $espacos, 3)),
        ];
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
