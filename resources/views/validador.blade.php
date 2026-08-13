<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validar Documento - CMP</title>

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
            font-size: 28px;
            margin-bottom: 16px;
        }

        .message {
            color: #495057;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 28px;
        }

        form {
            text-align: left;
            margin-bottom: 8px;
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #212529;
            margin-bottom: 6px;
        }

        select,
        input[type="text"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            font-size: 15px;
            color: #212529;
            background: #ffffff;
        }

        select:focus,
        input[type="text"]:focus {
            outline: none;
            border-color: #0d6efd;
        }

        .error {
            color: #dc3545;
            font-size: 13px;
            margin-top: 6px;
        }

        .btn {
            display: inline-block;
            width: 100%;
            background: #0d6efd;
            color: #ffffff;
            text-decoration: none;
            border: none;
            padding: 13px 30px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn:hover {
            background: #0b5ed7;
        }

        .back-link {
            display: inline-block;
            margin-top: 18px;
            color: #6c757d;
            font-size: 13px;
            text-decoration: none;
        }

        .back-link:hover {
            color: #495057;
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
            h1 { font-size: 23px; }
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

        <h1>Validar Documento</h1>

        <div class="message">
            Introduza o tipo de documento e o número DUC indicado no documento para
            consultar e validar a sua autenticidade — o mesmo resultado que obteria ao ler o QR Code.
        </div>

        <form method="POST" action="{{ route('validar.submit') }}">
            @csrf

            <div class="field">
                <label for="tipo">Tipo de Documento</label>
                <select name="tipo" id="tipo" required>
                    <option value="" disabled {{ old('tipo') ? '' : 'selected' }}>Selecione o tipo de documento</option>
                    @foreach ($tipos as $chave => $tipo)
                        <option value="{{ $chave }}" {{ old('tipo') === $chave ? 'selected' : '' }}>
                            {{ $tipo['label'] }}
                        </option>
                    @endforeach
                </select>
                @error('tipo')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="field">
                <label for="duc">Número DUC</label>
                <input type="text" name="duc" id="duc" inputmode="numeric" autocomplete="off"
                       placeholder="Ex: 123456" value="{{ old('duc') }}" required>
                @error('duc')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn">Validar documento</button>
        </form>

        <a href="{{ route('home') }}" class="back-link">&larr; Voltar</a>

        <div class="footer">
            <strong>Câmara Municipal da Praia</strong><br>
            Sistema de Gestão Documental<br><br>
            <strong>Contact Center:</strong> 8005002
        </div>

    </div>
</div>

</body>
</html>
