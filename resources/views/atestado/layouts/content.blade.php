<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <style>

        /* =========================
           CONFIGURAÇÃO DA PÁGINA
        ==========================*/
        @page {
            margin: 120px 40px 200px 40px; /* topo direita baixo esquerda */
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        /* =========================
           HEADER FIXO
        ==========================*/
        header {
            position: fixed;
            top: -100px;
            left: 0;
            right: 0;
            height: 100px;
            text-align: center;
        }

        /* =========================
           CONTEÚDO
        ==========================*/
        main {
            margin-top: 10px;
        }

        p {
            line-height: 1.8;
            font-size: 14px;
            text-align: justify;
        }

        /* =========================
           ASSINATURA FIXA
        ==========================*/
        .assinatura-fixa {
            position: fixed;
            bottom: 110px; /* fica acima do footer */
            left: 0;
            right: 0;
            text-align: center;
        }

        /* =========================
           FOOTER FIXO
        ==========================*/
        footer {
            position: fixed;
            bottom: -150px;
            left: 0;
            right: 0;
            height: 120px;
            text-align: center;
            font-size: 10px;
        }

        .page-number:before {
            content: "Página " counter(page);
        }

    </style>
</head>
<body>

<!-- =========================
     HEADER
==========================-->
<header>
    <img src="{{ public_path('images/logo_CMPRAIA.png') }}" 
         alt="Logo" 
         style="height:80px;">

    <h2>Câmara Municipal da Praia</h2>

    <h4>{{ $assinatura->delegacaoDirecao ?? '' }}</h4>

    <h4>
        {{ $assinatura->tipoPedido ?? '' }} 
        Nº {{ $assinatura->numeroPedido ?? '' }}
    </h4>
</header>


<!-- =========================
     CONTEÚDO DINÂMICO
==========================-->
<main>
    @yield('content')
</main>


<!-- =========================
     ASSINATURA FIXA
==========================-->
<div class="assinatura-fixa">

    <div style="font-size: 13px;">
        {{ $assinatura->quem_assinatura ?? 'Diretor(a) / Delegado(a)' }}
    </div>

    <div>
        @if (!empty($assinatura->assinatura))
            {!! $assinatura->assinaturaHtml(200) !!}
        @endif
    </div>

    <div style="margin-top: 5px; font-weight: bold;">
        {{ $assinatura->nomeAssina ?? '' }}
    </div>

</div>


<!-- =========================
     FOOTER FIXO
==========================-->
<footer>

    @<span>{{ $assinatura->codBarra ?? '' }}</span>@

    <div>
        {{ $assinatura->contra_prova ?? '' }}<br>

        Praça Alexandre Albuquerque - Praia - Santiago - Cabo Verde - CP.108<br>

        TEL.:(238) 5347005 / 5347000 - 
        site: www.cmpraia.cv - 
        email: camaradapraia@gmail.com
    </div>

</footer>

</body>
</html>
