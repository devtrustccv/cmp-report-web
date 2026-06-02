<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestão Documental - CMP</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

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
            max-width: 680px;
        }

        .card {
            background: #ffffff;
            border-radius: 18px;
            padding: 48px;
            text-align: center;
            box-shadow:
                0 12px 35px rgba(0,0,0,0.08),
                0 3px 12px rgba(0,0,0,0.04);
            border-top: 6px solid #0d6efd;
        }

        .logo-container {
            width: 105px;
            height: 105px;
            margin: 0 auto 24px;
            border-radius: 50%;
            background: #ffffff;
            border: 3px solid #0d6efd;
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

        .system-label {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #0d6efd;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        h1 {
            color: #212529;
            font-size: 31px;
            margin-bottom: 16px;
        }

        .message {
            color: #495057;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 26px;
        }

        .info-box {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 18px;
            color: #495057;
            font-size: 14px;
            line-height: 1.7;
            text-align: left;
            margin-bottom: 28px;
        }

        .info-box strong {
            color: #212529;
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
            .card {
                padding: 34px 24px;
            }

            h1 {
                font-size: 25px;
            }

            .info-box {
                text-align: left;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">

        <div class="logo-container">
            <img src="{{ asset('images/logo_CMPRAIA.png') }}" alt="Câmara Municipal da Praia">
        </div>

        <div class="system-label">
            Câmara Municipal da Praia
        </div>

        <h1>Sistema de Gestão Documental</h1>

        <div class="message">
            Este portal é destinado à consulta, validação e verificação de documentos
            emitidos pela Câmara Municipal da Praia.
        </div>

        <div class="info-box">
            <strong>Informações disponíveis neste sistema:</strong><br><br>

            • Consulta de documentos emitidos pela Câmara Municipal da Praia<br>
            • Validação de documentos através de QR Code<br>
            • Verificação de autenticidade documental<br>
            • Acesso seguro a documentos oficiais disponibilizados pelo município
        </div>

        <a href="https://www.lojacmp.com/autentica-recibo" class="btn">
            Validar documento
        </a>

        <div class="footer">
            <strong>Câmara Municipal da Praia</strong><br>
            Sistema de Gestão Documental<br><br>

            www.lojacmp.com/autentica-recibo<br>
            <strong>Contact Center:</strong> 8005002
        </div>

    </div>
</div>

</body>
</html>