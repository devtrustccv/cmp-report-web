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

    /** Só se preenche com "=" quando cabem pelo menos estes (ou seja, mais de 2) */
    public const MINIMO_IGUAIS = 3;

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

        // menos do que MINIMO_IGUAIS de cada lado: não vale a pena centrar com "="
        if ($n < self::MINIMO_IGUAIS) {
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

    /**
     * Percorre o HTML do conteúdo e, em cada <p> que acaba em @preencher, simula a quebra de
     * linhas do dompdf (mesmas regras de Dompdf\FrameReflower\Text::line_break e mesmas métricas)
     * para saber quanto espaço sobra na última linha. Se não couberem pelo menos
     * MINIMO_IGUAIS "=", o preenchimento é retirado.
     */
    public static function ajustarPreenchimentos(
        string $html,
        string $fonte = 'lora',
        string $tamanho = '20px',
        float $larguraPt = self::LARGURA_PT
    ): string {
        $fm      = self::metrics();
        $familia = self::FONTES_TTF[$fonte]['familia'] ?? self::FONTES_EMBUTIDAS[$fonte] ?? $fonte;
        $sizePt  = self::emPt($tamanho);

        $fonts = [];
        foreach (['normal', 'bold', 'italic', 'bold_italic'] as $estilo) {
            $fonts[$estilo] = $fm->getFont($familia, $estilo) ?? $fm->getFont('helvetica', 'normal');
        }

        return preg_replace_callback('#<p\b([^>]*)>(.*?)</p>#su', function (array $m) use ($fm, $fonts, $sizePt, $larguraPt) {
            // só parágrafos que ACABAM em @preencher
            if (!preg_match('#^(.*)<span class="preencher">=+</span>(\s*)$#su', $m[2], $partes)) {
                return $m[0];
            }

            $pItalico = (bool) preg_match('#class="[^"]*\bitalico\b#', $m[1]);
            $sobra    = self::sobraUltimaLinha($partes[1], $pItalico, $fm, $fonts, $sizePt, $larguraPt);
            $igual    = $fm->getTextWidth('=', $fonts[$pItalico ? 'italic' : 'normal'], $sizePt);

            if ($sobra + 0.01 >= self::MINIMO_IGUAIS * $igual) {
                return $m[0];
            }

            // não cabem "=" suficientes: tira o preenchimento
            return '<p' . $m[1] . '>' . rtrim($partes[1]) . '</p>';
        }, $html) ?? $html;
    }

    /** Espaço (pt) que sobra na última linha do texto HTML de um parágrafo. */
    private static function sobraUltimaLinha(string $htmlTexto, bool $pItalico, FontMetrics $fm, array $fonts, float $sizePt, float $larguraPt): float
    {
        $negrito = 0;
        $italico = $pItalico ? 1 : 0;
        $pilha   = [];

        $linha     = 0.0;   // largura já ocupada na linha atual
        $vazia     = true;  // linha atual ainda sem palavras
        $espaco    = false; // há um espaço pendente antes da próxima palavra
        $fonteEsp  = $fonts['normal'];

        foreach (preg_split('#(<[^>]+>)#u', $htmlTexto, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY) as $parte) {
            if ($parte[0] === '<') {
                if (preg_match('#^</\s*(\w+)#', $parte, $t)) {
                    // fecha a última tag aberta com este nome
                    for ($i = count($pilha) - 1; $i >= 0; $i--) {
                        if ($pilha[$i][0] === strtolower($t[1])) {
                            $negrito -= $pilha[$i][1];
                            $italico -= $pilha[$i][2];
                            array_splice($pilha, $i, 1);
                            break;
                        }
                    }
                } elseif (preg_match('#^<\s*(\w+)#', $parte, $t)) {
                    $tag = strtolower($t[1]);
                    if ($tag === 'br') {
                        $linha = 0.0; $vazia = true; $espaco = false;
                        continue;
                    }
                    $b = in_array($tag, ['strong', 'b'], true) ? 1 : 0;
                    $i = in_array($tag, ['em', 'i'], true) || preg_match('#class="[^"]*\bitalico\b#', $parte) ? 1 : 0;
                    $negrito += $b;
                    $italico += $i;
                    $pilha[] = [$tag, $b, $i];
                }
                continue;
            }

            $font = $fonts[($negrito > 0 ? 'bold' : '') . ($negrito > 0 && $italico > 0 ? '_' : '') . ($italico > 0 ? 'italic' : '')] ?? $fonts['normal'];
            $texto = html_entity_decode($parte, ENT_QUOTES | ENT_HTML5, 'UTF-8');

            // palavras separadas por espaço; os hífenes também permitem quebra (como no dompdf)
            foreach (preg_split('/([^\S\xA0\x{202F}\x{2007}]+|\-+)/u', $texto, -1, PREG_SPLIT_DELIM_CAPTURE) as $k => $peca) {
                if ($peca === '') {
                    continue;
                }
                if ($k % 2 === 1 && trim($peca) === '') { // separador de espaço
                    if (!$vazia) {
                        $espaco = true;
                        $fonteEsp = $font;
                    }
                    continue;
                }

                $w   = $fm->getTextWidth($peca, $font, $sizePt);
                $esp = $espaco ? $fm->getTextWidth(' ', $fonteEsp, $sizePt) : 0.0;

                if (!$vazia && $linha + $esp + $w > $larguraPt + 0.01) {
                    // não cabe: vai para a linha seguinte
                    $linha = $w;
                } else {
                    $linha += $esp + $w;
                }

                $vazia  = false;
                $espaco = false;
            }
        }

        if ($espaco) { // espaço entre o texto e o @preencher
            $linha += $fm->getTextWidth(' ', $fonteEsp, $sizePt);
        }

        return $larguraPt - $linha;
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
