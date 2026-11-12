{{--
    Layout base dos reports do Serviço de Licenciamento Comercial.

    Parâmetros (podem ser definidos no topo de cada view filha com @php ... @endphp):
      $fonte          -> 'lora' | 'arial' | 'times' | 'courier' | ou um font-family CSS completo
                         (lora/arial são TTF em resources/fonts, ver App\Http\Helpers\LinhaPreenchida::FONTES_TTF)
      $tamanhoFonte   -> tamanho do texto do corpo (ex.: '1.25rem' = 20px)
      $alturaLinha    -> line-height do corpo (ex.: 1.8)
      $corTexto       -> cor do texto do corpo (ex.: '#333333')
      $marcaAgua      -> true/false: mostra o logo em fundo
--}}
@php
    $fonte        = $fonte ?? 'lora';
    $fontFamily   = \App\Http\Helpers\LinhaPreenchida::fontFamilyCss($fonte);
    $tamanhoFonte = $tamanhoFonte ?? '1.25rem';
    $alturaLinha  = $alturaLinha ?? 1.8;
    $corTexto     = $corTexto ?? '#333333';
    $marcaAgua    = $marcaAgua ?? true;
@endphp
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <style>
        {!! \App\Http\Helpers\LinhaPreenchida::fontFaceCss() !!}

        @page {
            margin: 175px 60px 60px 60px;
        }

        body {
            font-family: {!! $fontFamily !!};
            font-size: {{ $tamanhoFonte }};
            line-height: {{ $alturaLinha }}; /* dá respiro entre as linhas */
            color: {{ $corTexto }};
        }

        /* ---------- Cabeçalho (sempre centralizado) ---------- */
        header {
            position: fixed;
            top: -150px;
            left: 0;
            right: 0;
            height: 140px;
            text-align: center;
            font-family: {!! $fontFamily !!}; /* mesma fonte do texto ($fonte) */
        }

        header img {
            width: 75px;
            height: 75px;
            display: block;
            margin: 0 auto 8px auto;
        }

        header .direcao {
            font-size: 20px;
            font-weight: bold;
            line-height: 1.2;
        }

        header .servico {
            font-size: 18px;
            font-weight: bold;
            line-height: 1.2;
        }

        /* ---------- Marca de água (logo em fundo) ---------- */
        .marca-agua {
            position: fixed;
            /* Área útil A4: 674px x 858px (página 794x1123 menos margens do @page).
               Logo 600x625 -> left = (674-600)/2, top = (858-625)/2 */
            top: 40px;
            left: 37px;
            width: 600px;
            height: 625px;
            opacity: 0.07;
            z-index: -1;
        }

        /* ---------- Corpo ---------- */
        /*
         * Coluna de texto com 600px, centrada na página.
         * Se mudar a largura, mudar também LinhaPreenchida::LARGURA_PT (px x 0.75).
         * padding-top = espaço entre o cabeçalho e o primeiro elemento (título / data / assunto).
         */
        main {
            width: 600px;
            margin: 0 auto;
            padding-top: 25px;
        }

        p {
            text-align: justify;
            margin: 0 0 12px 0;
            overflow: hidden; /* corta o excesso do @@preencher */
        }

        /*
         * @@preencher: "=====" até ao fim da linha.
         * A margem negativa faz o dompdf achar que cabe na linha atual;
         * o que passa da margem é cortado pelo overflow:hidden do <p>.
         */
        .preencher {
            white-space: nowrap;
            font-weight: bold;
            margin-right: -20000px; /* tem de ser maior que a largura dos 300 "=": assim nunca salta para a linha de baixo */
        }

        /* componente linha-preenchida: "==== texto ====" centrado; nº de "=" calculado em PHP */
        p.linha-preenchida {
            text-align: left; /* a largura já é exata (LinhaPreenchida) */
            overflow: hidden;
        }

        .data-local {
            font-weight: bold;
            margin: 0 0 25px 0;
        }

        .titulo-documento {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 0 0 40px 0;
        }

        .assunto {
            font-weight: bold;
            text-decoration: underline;
            margin: 0 0 40px 0;
        }

        .italico { font-style: italic; }
        .negrito { font-weight: bold; }

        /* data no fim do documento: "Praia, <span class=\"data-emissao\">12 de Novembro de 2026.</span>" */
        .data-emissao {
            font-weight: bold;
            font-size: 16px;
        }
        .centro  { text-align: center; }

        .espaco { height: 20px; }

        .assinatura {
            margin-top: 60px;
            text-align: center;
        }

        .assinatura .linha {
            width: 260px;
            margin: 45px auto 4px auto;
            border-top: 1px solid #000;
        }

        /* ---------- Rodapé ---------- */
        footer {
            position: fixed;
            bottom: -55px;
            left: 0;
            right: 0;
            height: 55px;
            text-align: center;
            font-size: 10px;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 1.3;
        }
    </style>
</head>
<body>

    @if($marcaAgua)
        <img class="marca-agua" src="{{ public_path('images/logo_CMPRAIA.png') }}" alt="">
    @endif

    <header>
        <img src="{{ public_path('images/logo_CMPRAIA.png') }}" alt="Logo">
        <div class="direcao">DIREÇÃO DE ADMINISTRAÇÃO FISCAL</div>
        <div class="servico">Serviço de Licenciamento Comercial</div>
    </header>

    <footer>
        Praça Alexandre Albuquerque - Praia - Santiago - Cabo Verde - CP.108<br>
        TEL.:(238) 5347005/5347000 - site: www.cmpraia.cv - email: camaradapraia@gmail.com
    </footer>

    <main>
        {{-- só deixa o "=" de fim de parágrafo quando cabem pelo menos 3 (LinhaPreenchida::MINIMO_IGUAIS) --}}
        {!! \App\Http\Helpers\LinhaPreenchida::ajustarPreenchimentos($__env->yieldContent('content'), $fonte, $tamanhoFonte) !!}
    </main>

</body>
</html>
