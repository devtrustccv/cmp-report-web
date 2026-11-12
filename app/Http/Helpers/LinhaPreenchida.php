<?php

namespace App\Http\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\FontMetrics;

/**
 * Calcula quantos "=" cabem de cada lado de um texto para formar
 * "======= texto =======" com a largura exata da área de texto,
 * usando as mesmas métricas de fonte que o dompdf usa ao desenhar.
 *
 * Também é aqui que estão as fontes TTF dos reports (resources/fonts/...),
 * usadas tanto no @font-face do layout como na medição.
 */
class LinhaPreenchida
{
    /** Largura da coluna de texto em pt (main { width: 600px } no layout = 450pt) */
    public const LARGURA_PT = 450.0;

    /** Fontes embutidas do dompdf (não precisam de ficheiro) */
    private const FONTES_EMBUTIDAS = [
        'times'   => 'times',
        'courier' => 'courier',
    ];

    /** Fontes TTF do projeto: chave usada em $fonte => família dompdf + ficheiros em resources/fonts/<pasta> */
    public const FONTES_TTF = [
        'arial' => [
            'familia'   => 'arial-ttf',
            'css'       => "'arial-ttf', Arial, Helvetica, sans-serif",
            'pasta'     => 'arial',
            'ficheiros' => [
                'normal'      => 'arial.ttf',
                'bold'        => 'arialbd.ttf',
                'italic'      => 'ariali.ttf',
                'bold_italic' => 'arialbi.ttf',
            ],
        ],
        'lora' => [
            'familia'   => 'lora-ttf',
            'css'       => "'lora-ttf', Georgia, serif",
            'pasta'     => 'lora',
            'ficheiros' => [
                'normal'      => 'Lora-Regular.ttf',
                'bold'        => 'Lora-Bold.ttf',
                'italic'      => 'Lora-Italic.ttf',
                'bold_italic' => 'Lora-BoldItalic.ttf',
            ],
        ],
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
        string $fonte = 'lora',
        string $tamanho = '20px',
        bool $italico = false,
        float $larguraPt = self::LARGURA_PT
    ): array {
        $fm = self::metrics();

        $familia = self::FONTES_TTF[$fonte]['familia'] ?? self::FONTES_EMBUTIDAS[$fonte] ?? $fonte;
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

    /** font-family CSS para a chave $fonte da view ('lora', 'arial', 'times', ...) */
    public static function fontFamilyCss(string $fonte): string
    {
        return self::FONTES_TTF[$fonte]['css'] ?? match ($fonte) {
            'times'   => "'Times New Roman', Times, serif",
            'courier' => "'Courier New', Courier, monospace",
            default   => $fonte,
        };
    }

    /** Regras @font-face de todas as fontes TTF (para o <style> do layout) */
    public static function fontFaceCss(): string
    {
        $css = '';

        foreach (self::FONTES_TTF as $f) {
            foreach ($f['ficheiros'] as $estilo => $ficheiro) {
                $css .= sprintf(
                    "@font-face { font-family: '%s'; font-weight: %s; font-style: %s; src: url('%s') format('truetype'); }\n",
                    $f['familia'],
                    str_contains($estilo, 'bold') ? 'bold' : 'normal',
                    str_contains($estilo, 'italic') ? 'italic' : 'normal',
                    self::caminho($f['pasta'], $ficheiro)
                );
            }
        }

        return $css;
    }

    private static function metrics(): FontMetrics
    {
        if (self::$metrics === null) {
            self::$metrics = Pdf::getDomPDF()->getFontMetrics();
            self::registarFontes(self::$metrics);
        }

        return self::$metrics;
    }

    /** Regista as fontes TTF no dompdf (ficam em cache em storage/fonts) para medir com a fonte real. */
    private static function registarFontes(FontMetrics $fm): void
    {
        // pasta de cache de fontes do dompdf (config dompdf.font_cache)
        if (!is_dir(storage_path('fonts'))) {
            @mkdir(storage_path('fonts'), 0775, true);
        }

        $familias = $fm->getFontFamilies();

        foreach (self::FONTES_TTF as $f) {
            foreach ($f['ficheiros'] as $estilo => $ficheiro) {
                if (isset($familias[$f['familia']][$estilo])) {
                    continue; // já registado
                }

                $fm->registerFont(
                    [
                        'family' => $f['familia'],
                        'weight' => str_contains($estilo, 'bold') ? 'bold' : 'normal',
                        'style'  => str_contains($estilo, 'italic') ? 'italic' : 'normal',
                    ],
                    self::caminho($f['pasta'], $ficheiro)
                );
            }
        }
    }

    private static function caminho(string $pasta, string $ficheiro): string
    {
        return str_replace('\\', '/', resource_path("fonts/{$pasta}/{$ficheiro}"));
    }

    private static function emPt(string $tamanho): float
    {
        $v = (float) $tamanho;

        return match (true) {
            str_ends_with($tamanho, 'pt')  => $v,
            str_ends_with($tamanho, 'rem'),
            str_ends_with($tamanho, 'em')  => $v * 16 * 0.75, // 1rem = 16px
            default => $v * 0.75, // px -> pt
        };
    }
}
