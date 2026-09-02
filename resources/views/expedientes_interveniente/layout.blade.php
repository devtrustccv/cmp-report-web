<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Lista de Expedientes Encaminhados por Interveniente')</title>

    <style>
        @page {
            margin: 150px 55px 60px 55px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        header {
            position: fixed;
            top: -140px;
            left: 0;
            right: 0;
            height: 130px;
        }

        header .emblema {
            text-align: center;
        }

        header .emblema img {
            width: 42px;
            height: 42px;
            display: block;
            margin: 0 auto 4px auto;
        }

        header .pais,
        header .camara {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }

        header .direcao {
            font-size: 12px;
            font-style: italic;
            text-align: center;
        }

        header .titulo {
            font-size: 13px;
            font-style: italic;
            font-weight: bold;
            text-align: center;
            margin-top: 4px;
        }

        header .periodo {
            position: absolute;
            top: 0;
            right: 0;
            border: 1px solid #000;
            padding: 4px 8px;
            font-size: 10px;
            line-height: 1.6;
        }

        footer {
            position: fixed;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 40px;
            font-size: 10px;
            border-top: 1px solid #000;
            padding-top: 4px;
        }

        footer .pagenum:before {
            content: counter(page);
        }

        .content {
            margin-top: 5px;
        }
    </style>
</head>
<body>

<header>
    <div class="periodo">
        De:............. {{ $dataInicio }}<br>
        Até: ............ {{ $dataFim }}
    </div>
    <div class="emblema">
        <img src="{{ public_path('images/logo_CMPRAIA.png') }}" alt="Brasão">
    </div>
    <div class="pais">REPÚBLICA DE CABO VERDE</div>
    <div class="camara">Câmara Municipal da Praia</div>
    <div class="direcao">Direcção de Urbanismo</div>
    <div class="titulo">@yield('title', 'Lista de Expedientes Encaminhados por Interveniente')</div>
</header>

<footer>
    <table width="100%" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width:40%;">Util.: {{ $utilizador ?? '' }}</td>
            <td style="width:20%; text-align:center;">Pág. <span class="pagenum"></span> de {{ $totalPaginas ?? '' }}</td>
            <td style="width:40%; text-align:right;">Data: {{ $dataEmissao ?? '' }}</td>
        </tr>
    </table>
</footer>

<div class="content">
    @yield('content')
</div>

</body>
</html>
