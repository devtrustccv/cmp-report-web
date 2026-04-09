<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Erro</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f3f5; /* cinza */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .box {
            text-align: center;
            background: #0d6efd; /* azul */
            color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 420px;
        }

        h1 {
            font-size: 40px;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            margin: 10px 0;
        }

        .small {
            font-size: 14px;
            opacity: 0.8;
            margin-top: 15px;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>⚠️ Erro</h1>
    <p>{{ $message ?? 'Documento não encontrado' }}</p>

    <p class="small">
        Caso o problema persista, contacte o administrador do sistema.
    </p>
</div>

</body>
</html>