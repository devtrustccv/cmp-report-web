<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento não encontrado</title>

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            background: #f4f6f9;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 640px;
        }

        .card {
            background: #ffffff;
            border-radius: 18px;
            padding: 48px;
            text-align: center;
            box-shadow: 0 12px 35px rgba(0,0,0,0.08);
            border-top: 6px solid #ffc107;
        }

        .logo-container {
            width: 105px;
            height: 105px;
            margin: 0 auto 24px;
            border-radius: 50%;
            background: #ffffff;
            border: 3px solid #ffc107;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.10);
        }

        .logo-container img {
            width: 72px;
            height: 72px;
            object-fit: contain;
        }

        .system-name {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #0d6efd;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .error-code {
            display: inline-block;
            background: #fff8e1;
            color: #b8860b;
            font-size: 13px;
            font-weight: 700;
            padding: 7px 14px;
            border-radius: 999px;
            margin-bottom: 18px;
        }

        h1 {
            color: #212529;
            font-size: 28px;
            margin-bottom: 14px;
        }

        .message {
            color: #495057;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 26px;
        }

        .help-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 16px;
            color: #6c757d;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 28px;
            text-align: left;
        }

        .btn {
            display: inline-block;
            background: #0d6efd;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
        }

        .btn:hover {
            background: #0b5ed7;
        }

        .footer {
            margin-top: 28px;
            padding-top: 18px;
            border-top: 1px solid #edf0f3;
            color: #8a939b;
            font-size: 12px;
            line-height: 1.7;
        }

        .footer strong {
            color: #6c757d;
        }

        @media (max-width: 600px) {
            .card { padding: 34px 24px; }
            h1 { font-size: 22px; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">

        <div class="logo-container">
            <img src="{{ asset('images/logo_CMPRAIA.png') }}" alt="Câmara Municipal da Praia">
        </div>

        <div class="system-name">
            Sistema de Gestão Documental - CMP
        </div>

        <div class="error-code">
            DOCUMENTO NÃO ENCONTRADO
        </div>

        <h1>Não encontrámos nenhum documento com esse DUC</h1>

        <div class="message">
            Não foi possível localizar um documento correspondente ao número DUC indicado.
        </div>

        <div class="help-box">
            Verifique se o número DUC foi introduzido corretamente e tente novamente.
            Se o problema persistir, contacte o suporte da Câmara Municipal da Praia.
        </div>

        <a href="{{ route('home') }}" class="btn">
            Tentar novamente
        </a>

        <div class="footer">
            <strong>Contact Center:</strong> 8005002<br>
            Câmara Municipal da Praia · Sistema de Gestão Documental
        </div>

    </div>
</div>

</body>
</html>
