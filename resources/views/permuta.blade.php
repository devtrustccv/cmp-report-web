<!DOCTYPE html>
<html lang="pt">
    <head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 20mm;
        }

        body{
            font-family: "Times New Roman", serif;
            font-size:14px;
            color:#000;
        }

        .header{
            text-align:center;
            line-height:1.4;
        }

        .header .modelo{
            font-size:14px;
        }

        .header .titulo{
            font-size:20px;
            font-weight:bold;
            text-transform:uppercase;
        }

        .numero{
            text-align:right;
            margin-top:15px;
            font-size:18px;
        }

        .assunto{
            margin-top:35px;
            text-align:center;
            font-size:18px;
            font-weight:bold;
            line-height:1.5;
        }

        .valores{
            width:100%;
            margin-top:25px;
            border-collapse:collapse;
        }

        .valores td{
            padding:5px;
        }

        .texto{
            margin-top:15px;
            text-align:justify;
            line-height:2;
        }

        .linha{
            border-bottom:1px solid #000;
            display:inline-block;
            min-width:120px;
            padding:0 5px;
        }

        .assinaturas{
            margin-top:50px;
            width:100%;
        }

        .assinaturas td{
            width:50%;
            text-align:center;
        }

        .assinatura{
            margin-top:60px;
            border-top:1px solid #000;
            width:200px;
            display:inline-block;
            padding-top:5px;
        }
    </style>

    </head>
    <body>

        <div class="header">
            <div class="modelo">
                Modelo nº 3 (Artigo 74º)
            </div>

            <div>
                República de Cabo Verde
            </div>

            <div class="titulo">
                Câmara Municipal da Praia
            </div>
        </div>

        <div class="numero">
            Nº {{ $dados?->numero ?? '' }}
        </div>

        <div class="assunto">
            IUP sobre a transmissão de imobiliários<br>
            por título sucessório
        </div>

        <table class="valores">
            <tr>
                <td>IUP</td>
                <td>{{ $dados?->percentagem ?? "" }}</td>
                <td style="text-align:right">
                    {{ $dados?->valor ?? "" }}
                </td>
            </tr>

            <tr>
                <td colspan="2">Total</td>
                <td style="text-align:right">
                    {{ $dados?->total ?? "" }}
                </td>
            </tr>
        </table>

        <div class="texto">

        Pagou o Sr.

        <span class="linha">
            {{ $dados?->nome ?? "" }}
        </span>

        a quantia de

        <span class="linha">
            {{ $dados?->valorExtenso ?? "" }}
        </span>

        proveniente de contrato de permuta entre

        <span class="linha">
            {{ $dados?->parteA ?? "" }}
        </span>

        e

        <span class="linha">
            {{ $dados?->parteB ?? "" }}
        </span>

        relativo aos prédios descritos como

        <span class="linha">
            {{ $dados?->descricao ?? "" }}
        </span>

        </div>
    </body>
</html>