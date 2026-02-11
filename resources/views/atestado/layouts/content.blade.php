<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <style>
        @page {
            margin: 120px 40px 100px 40px; /* top right bottom left */
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 80px;
            text-align: center;
        }

        p {
            line-height: 1.8; /* ou 2, conforme o espaço que desejar */
            font-size: 14px; /* aumenta a fonte */
            text-align: justify; /* justifica o texto */
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 60px;
            text-align: center;
            font-size: 10px;
        }

        .page-number:before {
            content: "Página " counter(page);
        }

        main {
            margin-top: 10px;
        }

         /* Área de assinatura global */
        .assinatura {
            position: relative; /* relativo ao main */
            margin-top: 100px;
            text-align: center;
            border-top: 1px solid #000;
            width: 300px; /* largura da assinatura */
            padding-top: 5px;
            font-size: 12px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

<header>
    <img src="{{ public_path('images/logo_CMPRAIA.png') }}" alt="Logo" style="height:80px;">
    <h2>Câmara Municipal da Praia</h2>
    <h4>{{ $assinatura->delegacaoDirecao ?? '' }}</h4>
    <h4>{{ $assinatura->tipoPedido ?? '' }} Nº {{ $assinatura->numeroPedido ?? '' }}</h4>
</header>

<footer>
    <span style="text-align: center;">{{ $assinatura->codBarra ?? '' }} </span>
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <!-- Coluna do texto, 75% -->
            <td style="width: 100%; vertical-align: top; padding-left: 0; text-align: center;">
                <span>{{$assinatura->contra_prova ?? ''}}</span></br>
                Praça Alexandre Albuquerque - Praia - Santiago - Cabo Verde - CP.108 
                TEL.:(238) 5347005/5347000 - site: www.cmpraia.cv - 
                email:camaradapraia@gmail.com
            </td>

            <!-- Coluna do QR code, 25% 
            <td style="width: 25%; text-align: right; vertical-align: top; padding-left: 20px;">
                @if(!empty($qrCodePath))
                    <img alt="QR Code" src="{{ $qrCodePath }}" style="width:80px; height:80px;">
                @endif
            </td>-->
        </tr>
    </table>

</footer>

<main style ="margin-top: 115px;">
    @yield('content')
</main>

<div style="text-align:center; margin-top:60px; position: relative; width: 100%;">
    <!-- Linha de assinatura -->
    <div style="margin-bottom: -2px; font-size: 13px;">
        {{ $assinatura->quem_assinatura ?? 'Diretor(a) / Delegado (a)' }}
    </div>
    <div style="padding-top: -2px; position: relative;">
        @if (!empty($assinatura->assinatura))
            {!! $assinatura->assinaturaHtml(200) !!}
        @endif
    </div>

    <!-- Nome abaixo da linha -->
    <div style="margin-top: 5px; font-weight: bold;">
        {{ $assinatura->nomeAssina ?? '' }}
    </div>
</div>


</body>
</html>