<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <style>
        @page {
            margin: 130px 45px 90px 45px;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 15px;
        }

        header {
            position: fixed;
            top: -110px;
            left: 0;
            right: 0;
            height: 110px;
            text-align: center;
        }

        header img {
            width: 60px;
            height: 60px;
            display: block;
            margin: 0 auto 8px auto;
        }

        header .direcao {
            font-size: 15px;
            font-weight: bold;
        }

        header .titulo {
            font-size: 18px;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 18px;
        }

        p {
            line-height: 1.9;
            font-size: 15px;
            text-align: justify;
        }

        footer {
            position: fixed;
            bottom: -70px;
            left: 0;
            right: 0;
            height: 70px;
            font-size: 10px;
        }

        main {
            margin-top: 10px;
        }
    </style>
</head>
<body>

    @include('components.watermark', ['estado' => null])

    <header>
        <img src="{{ public_path('images/logo_CMPRAIA.png') }}" alt="Logo">
        <div class="direcao">{{ $dados?->direcao ?? '' }}</div>
        <div class="titulo">{{ $tipo->titulo() }}</div>
    </header>

    <footer>
        <table style="width:100%; border-collapse: collapse;">
            <tr>
                <td style="width:80%; vertical-align:middle;">
                    Praça Alexandre Albuquerque - Praia - Santiago - Cabo Verde - CP.108
                    TEL.:(238) 5347005/5347000 - site: www.cmpraia.cv - email: camaradapraia@gmail.com
                </td>
                @if(!empty($qrcode_base64))
                <td style="width:20%; text-align:right;">
                    <img src="data:image/png;base64,{{ $qrcode_base64 }}" style="width:55px; height:55px;">
                </td>
                @endif
            </tr>
        </table>
    </footer>

    <main>
        @yield('content')
    </main>

</body>
</html>
