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



        .espacador-assinatura {
            height: 60px;
            display: block;
            width: 100%;
        }

        .assinatura {
            text-align: center;
            border-top: 1px solid #000;
            width: 300px;
            padding-top: 5px;
            font-size: 12px;
            margin-left: auto;
            margin-right: auto;
            page-break-inside: avoid;   /* nunca corta nome + assinatura + texto ao meio */
        }

        .tabela-assinatura {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .tabela-assinatura td {
            border: none;
        }


        .watermark {
            position: fixed;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-35deg);

            font-size: 90px;
            font-weight: bold;

            opacity: 0.12;
            z-index: -1;

            white-space: nowrap;
        }

        .watermark.valid {
            color: #008000;
        }

        .watermark.invalid {
            color: #cc0000;
        }

    </style>
</head>
<body>
    @if($verificacao !== null && $verificacao !== '')

        <div class="watermark {{ $verificacao == 2 ? 'valid' : 'invalid' }}">

            {{ $verificacao == 2 ? 'VÁLIDO' : 'INVÁLIDO' }}

        </div>

    @endif

<header>
    <img src="{{ public_path('images/logo_CMPRAIA.png') }}" alt="Logo" style="height:80px;">
    <h2>Câmara Municipal da Praia</h2>
    <h4>{{ $assinatura->delegacaoDirecao ?? '' }}</h4>
    <h4>{{ $assinatura->tipoPedido ?? '' }} Nº {{ $assinatura->numeroPedido ?? '' }}</h4>
</header>

<footer>
    @<span style="text-align: center;">{{ $assinatura->codBarra ?? '' }} </span>@
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <!-- Coluna do texto, 75% -->
            <td style="width: 100%; vertical-align: top; padding-left: 0; text-align: center;">
                <span>{{$assinatura->contra_prova ?? ''}}</span></br>
                Praça Alexandre Albuquerque - Praia - Santiago - Cabo Verde - CP.108 
                TEL.:(238) 5347005/5347000 - site: www.cmpraia.cv - 
                email:camaradapraia@gmail.com
            </td>
            @if(!empty($qrcode_base64))
            <td style="text-align: right;">
                <img
                    src="data:image/png;base64,{{ $qrcode_base64 }}"
                    style="width:60px;height:60px;"
                >
            </td>
            @endif
        </tr>
    </table>

</footer>

<main style ="margin-top: 115px;">
    @yield('content')
</main>

<div class="espacador-assinatura"></div>

<div class="assinatura">
    <table class="tabela-assinatura">
        <tr>
            <td>
                <div style="font-size: 13px;">
                    {{ $assinatura->quem_assinatura ?? 'Diretor(a) / Delegado(a)' }}
                </div>

                <div style="margin-top:5px;">
                    @if (!empty($assinatura->assinatura))
                        {!! $assinatura->assinaturaHtml(200) !!}
                    @endif
                </div>

                <div style="margin-top: 5px; font-weight: bold;">
                    {{ $assinatura->nomeAssina ?? '' }}
                </div>
            </td>
        </tr>
    </table>
</div>




</body>
</html>