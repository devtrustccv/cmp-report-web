<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro do Sistema</title>

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

        .error-container {
            width: 100%;
            max-width: 600px;
        }

        .error-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 50px;
            text-align: center;
            box-shadow:
                0 10px 30px rgba(0,0,0,0.08),
                0 2px 10px rgba(0,0,0,0.04);
            border-top: 6px solid #0d6efd;
        }

        .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            background: #fff3cd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon svg {
            width: 42px;
            height: 42px;
            fill: #ff9800;
        }

        .error-code {
            font-size: 14px;
            font-weight: 600;
            letter-spacing: 2px;
            color: #0d6efd;
            margin-bottom: 12px;
        }

        h1 {
            color: #212529;
            font-size: 32px;
            margin-bottom: 15px;
        }

        .message {
            color: #495057;
            font-size: 17px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .help-text {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 35px;
        }

        .btn {
            display: inline-block;
            background: #0d6efd;
            color: white;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn:hover {
            background: #0b5ed7;
        }

        .footer {
            margin-top: 25px;
            font-size: 12px;
            color: #adb5bd;
        }

        @media (max-width: 600px) {
            .error-card {
                padding: 35px 25px;
            }

            h1 {
                font-size: 26px;
            }
        }

        .logo-container {
            width: 100px;
            height: 100px;
            margin: 0 auto 25px;
            border-radius: 50%;
            background: #ffffff;
            border: 3px solid #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.10);
        }

        .logo-container img {
            width: 70px;
            height: 70px;
            object-fit: contain;
        }
    </style>
</head>
<body>

<div class="error-container">
    <div class="error-card">

        <div class="logo-container">
            <img src="{{ asset('images/logo_CMPRAIA.png') }}" alt="CMP">
        </div>

        <div class="error-code">
            ERRO DO SISTEMA
        </div>

        <h1>Não foi possível concluir a operação</h1>

        <div class="message">
            {{ $message ?? 'O documento solicitado não foi encontrado ou não está disponível para consulta.' }}
        </div>

        <div class="help-text">
            Caso o problema persista, contacte o administrador do sistema ou tente novamente mais tarde.
        </div>

        <a href="javascript:history.back()" class="btn">
            Voltar
        </a>

        <div class="footer">
            Sistema de Gestão Documental - Câmara Municipal da Praia
        </div>

    </div>
</div>

</body>
</html>