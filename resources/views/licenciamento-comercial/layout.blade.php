{{--
    Layout base dos reports do Serviço de Licenciamento Comercial.

    Parâmetros (podem ser definidos no topo de cada view filha com @php ... @endphp):
      $fonte          -> 'times' | 'courier' | 'arial' | ou um font-family CSS completo
      $tamanhoFonte   -> tamanho do texto do corpo (ex.: '15px')
      $alturaLinha    -> line-height do corpo (ex.: 1.8)
      $marcaAgua      -> true/false: mostra o logo em fundo
--}}
@php
    $fontesDisponiveis = [
        'times'   => "'Times New Roman', Times, serif",
        'courier' => "'Courier New', Courier, monospace",
        'arial'   => "Arial, Helvetica, sans-serif",
    ];

    $fonte        = $fonte ?? 'arial';
    $fontFamily   = $fontesDisponiveis[$fonte] ?? $fonte;
    $tamanhoFonte = $tamanhoFonte ?? '18px';
    $alturaLinha  = $alturaLinha ?? 1.8;
    $marcaAgua    = $marcaAgua ?? true;
@endphp
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <style>
        @page {
            margin: 175px 60px 90px 60px;
        }

        body {
            font-family: {!! $fontFamily !!};
            font-size: {{ $tamanhoFonte }};
            line-height: {{ $alturaLinha }};
        }

        /* ---------- Cabeçalho (sempre centralizado) ---------- */
        header {
            position: fixed;
            top: -150px;
            left: 0;
            right: 0;
            height: 140px;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;
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
        main {
            margin-top: 10px;
        }

        p {
            text-align: justify;
            margin: 0 0 18px 0;
            overflow: hidden; /* corta o excesso do @@preencher */
        }

        /*
         * @@preencher: "=====" até ao fim da linha.
         * A margem negativa faz o dompdf achar que cabe na linha atual;
         * o que passa da margem é cortado pelo overflow:hidden do <p>.
         */
        .preencher {
            white-space: nowrap;
            margin-right: -3000px;
        }

        /* componente linha-preenchida: "==== texto ====" centrado na largura toda */
        .linha-preenchida {
            width: 100%;
            border-collapse: collapse;
            margin: 0 0 18px 0;
        }

        .linha-preenchida td {
            padding: 0;
            vertical-align: baseline;
        }

        .linha-preenchida .lp-lado {
            overflow: hidden;
            white-space: nowrap;
        }

        .linha-preenchida .lp-texto {
            width: 1%;
            white-space: nowrap;
            padding: 0 6px;
        }

        .data-local {
            font-weight: bold;
            margin: 10px 0 25px 0;
        }

        .titulo-documento {
            text-align: center;
            font-weight: bold;
            text-decoration: underline;
            margin: 10px 0 35px 0;
        }

        .assunto {
            font-weight: bold;
            text-decoration: underline;
            margin: 10px 0 35px 0;
        }

        .italico { font-style: italic; }
        .negrito { font-weight: bold; }
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
            bottom: -70px;
            left: 0;
            right: 0;
            height: 70px;
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
        @yield('content')
    </main>

</body>
</html>
