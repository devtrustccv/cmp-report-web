<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 25px 25px 150px 25px;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: -130px;
            left: 0;
            right: 0;
            height: 140px;
        }

        .top-bar {
            width: 100%;
            margin-bottom: 6px;
        }

        .top-bar td {
            font-size: 9px;
        }

        .cabecalho {
            text-align: center;
            margin-bottom: 12px;
        }

        .cabecalho img {
            width: 55px;
            height: 55px;
            display: block;
            margin: 0 auto 6px auto;
        }

        .cabecalho .republica {
            font-size: 10px;
        }

        .cabecalho .camara {
            font-size: 13px;
            font-weight: bold;
            margin-top: 2px;
        }

        .quadro {
            border: 1px solid #000;
            width: 100%;
        }

        .quadro-titulo {
            text-align: center;
            padding: 10px 6px;
            border-bottom: 1px solid #000;
        }

        .quadro-titulo .linha1 {
            font-weight: bold;
            font-size: 12px;
        }

        .quadro-titulo .linha2 {
            font-weight: bold;
            font-size: 12px;
        }

        .quadro-titulo .numero {
            text-align: right;
            font-size: 11px;
            text-decoration: underline;
        }

        .colunas {
            width: 100%;
        }

        .colunas td {
            vertical-align: top;
            padding: 14px 8px;
        }

        .col-caracteristicas {
            width: 30%;
            border-right: 1px solid #000;
        }

        .col-marca {
            width: 32%;
            border-right: 1px solid #000;
        }

        .col-proprietario {
            width: 38%;
        }

        .subtitulo {
            text-align: center;
            font-weight: bold;
            font-size: 11px;
            margin-top: 8px;
            margin-bottom: 8px;
        }

        .opcao {
            width: 100%;
            table-layout: fixed;
            font-size: 9.5px;
        }

        .opcao td {
            padding: 4px 0;
            overflow: hidden;
        }

        .opcao .label {
            width: 66%;
            white-space: nowrap;
        }

        .opcao .pontos {
            width: 20%;
            white-space: nowrap;
        }

        .opcao .caixa {
            width: 14%;
            text-align: right;
        }

        .checkbox {
            display: inline-block;
            width: 9px;
            height: 9px;
            border: 1px solid #000;
            text-align: center;
            line-height: 9px;
            font-size: 8px;
            font-weight: bold;
        }

        .separador {
            border-top: 1px solid #000;
            margin: 16px 0;
        }

        .campo-linha {
            margin-top: 10px;
        }

        .campo-valor {
            font-weight: bold;
        }

        .declarante {
            margin-top: 26px;
        }

        .pontilhado {
            border-bottom: 1px dotted #000;
            display: block;
            min-height: 22px;
            margin-top: 14px;
        }

        table.imposto {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
            font-size: 9px;
        }

        table.imposto th, table.imposto td {
            border: 1px solid #000;
            padding: 2px 4px;
            text-align: center;
        }

        .assinatura {
            margin-top: 28px;
        }

        .rodape-emissao {
            width: 100%;
            margin-top: 6px;
            font-size: 8px;
        }

        .rodape-pagamento {
            border: 1px solid #000;
            width: 100%;
            margin-top: 8px;
            border-collapse: collapse;
        }

        .rodape-pagamento td {
            padding: 4px 8px;
            vertical-align: middle;
            font-size: 9px;
        }

        .rodape-pagamento .divisor {
            border-left: 1px solid #000;
        }

        .validation-code {
            font-weight: bold;
            font-size: 13px;
        }
    </style>
</head>
<body>

@include('components.watermark', ['estado' => null])

<table class="top-bar">
    <tr>
        <td></td>
        <td style="text-align:right;">MOD.5 (art. 7º,nº5 do regulamento)</td>
    </tr>
</table>

<div class="cabecalho">
    <img src="{{ public_path('images/logo_CMPRAIA.png') }}" alt="Logo">
    <div class="republica">República de Cabo Verde</div>
    <div class="camara">Câmara Municipal da Praia</div>
</div>

<table class="quadro" cellspacing="0" cellpadding="0">
    <tr>
        <td class="quadro-titulo" colspan="3">
            <table width="100%">
                <tr>
                    <td style="width:100%; text-align:center;">
                        <div class="linha1">IMPOSTO MUNICIPAL SOBRE VEÍCULOS AUTOMÓVEIS</div>
                        <div class="linha2">DECLARAÇÃO PARA REGISTO DO DÍSTICO</div>
                    </td>
                    <td style="width:0;">
                        <div class="numero">{{ $dados->numero ?? '' }}</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr class="colunas">
        {{-- CARACTERÍSTICAS DO VEÍCULO --}}
        <td class="col-caracteristicas">
            <div class="subtitulo">Características do veículo</div>

            <div class="subtitulo" style="margin-top:10px;">ESPÉCIE</div>
            <table class="opcao">
                @foreach(['AUTOMOVEL' => 'Automóvel', 'MOTOCICLOS' => 'Motociclos'] as $chave => $rotulo)
                    <tr>
                        <td class="label">{{ $rotulo }}</td>
                        <td class="pontos">.....................</td>
                        <td class="caixa"><span class="checkbox">{{ ($dados->especie ?? null) === $chave ? 'X' : '' }}</span></td>
                    </tr>
                @endforeach
            </table>

            <div class="subtitulo" style="margin-top:10px;">CILINDRADA</div>
            <div style="text-align:center; font-size:8.5px; margin-top:-4px;">(centímetros cúbicos)</div>
            <table class="opcao" style="margin-top:4px;">
                @foreach([
                    '50-180' => 'De 50 até 180',
                    '180-350' => 'Mais de 180 até 350',
                    '350-750' => 'Mais de 350 até 750',
                    '750-1000' => 'Mais de 750 até 1000',
                    '1000-1300' => 'Mais de 1000 até 1300',
                    '1300-1750' => 'Mais de 1300 até 1750',
                    '1750-2600' => 'Mais de 1750 até 2600',
                    '2600-3500' => 'Mais de 2600 até 3500',
                    '3500+' => 'Mais de 3500',
                ] as $chave => $rotulo)
                    <tr>
                        <td class="label">{{ $rotulo }}</td>
                        <td class="pontos">.....</td>
                        <td class="caixa"><span class="checkbox">{{ ($dados->cilindrada ?? null) === $chave ? 'X' : '' }}</span></td>
                    </tr>
                @endforeach
            </table>

            <div class="separador"></div>

            <div class="campo-linha">
                <div>MATRÍCULA:</div>
                <div class="campo-valor" style="text-align:center; font-size:11px; margin-top:2px;">{{ $dados->matricula ?? '' }}</div>
            </div>

            <div class="separador"></div>

            <div class="campo-linha">Ano de matrícula...<span class="campo-valor">{{ $dados->anoMatricula ?? '' }}</span></div>
        </td>

        {{-- MARCA DO VEÍCULO --}}
        <td class="col-marca">
            <div class="subtitulo">Marca do Veículo</div>

            <div class="subtitulo" style="margin-top:10px;">AUTOMÓVEL</div>
            <table class="opcao">
                @foreach(['Austin','BMW','Citroen','Datsun','Fiat','Ford','Mercedes','Morris','Opel','Peugeot','Renault','Sinca','Toyota','Vauxball','Volkswagen'] as $marcaOpcao)
                    <tr>
                        <td class="label">{{ $marcaOpcao }}</td>
                        <td class="pontos">.....................</td>
                        <td class="caixa"><span class="checkbox">{{ ($dados->marcaCategoria ?? null) === 'AUTOMOVEL' && ($dados->marca ?? null) === $marcaOpcao ? 'X' : '' }}</span></td>
                    </tr>
                @endforeach
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="pontos">.....................</td>
                    <td class="caixa"><span class="checkbox"></span></td>
                </tr>
            </table>

            <div class="subtitulo" style="margin-top:12px;">MOTOCICLOS</div>
            <table class="opcao">
                @foreach(['BMW Heiuel MZ','BSA','OZ Jawa','Honda, Suzuky','Yamaha, Kawasaky'] as $marcaOpcao)
                    <tr>
                        <td class="label">{{ $marcaOpcao }}</td>
                        <td class="pontos">.....................</td>
                        <td class="caixa"><span class="checkbox">{{ ($dados->marcaCategoria ?? null) === 'MOTOCICLOS' && ($dados->marca ?? null) === $marcaOpcao ? 'X' : '' }}</span></td>
                    </tr>
                @endforeach
                <tr>
                    <td class="label">&nbsp;</td>
                    <td class="pontos">.....................</td>
                    <td class="caixa"><span class="checkbox"></span></td>
                </tr>
            </table>
        </td>

        {{-- PROPRIETÁRIO DO VEÍCULO --}}
        <td class="col-proprietario">
            <div class="subtitulo">PROPRIETÁRIO DO VEÍCULO</div>

            <div class="campo-linha">
                Nome: <span class="campo-valor" style="text-decoration:underline;">{{ $dados->proprietarioNome ?? '' }}</span>
            </div>

            <div class="campo-linha" style="margin-top:10px;">
                Residência ou Sede
                <span class="pontilhado">{{ $dados->proprietarioResidencia ?? '' }}</span>
            </div>

            <div class="declarante">
                O declarante,
                <span class="pontilhado"></span>
            </div>

            <div class="separador"></div>

            <div class="subtitulo">ELEMENTOS SOBRE O IMPOSTO</div>

            <table class="imposto">
                <tr>
                    <th rowspan="2" style="width:16%;">Ano</th>
                    <th colspan="3">Dístico</th>
                    <th rowspan="2">Taxa</th>
                </tr>
                <tr>
                    <th style="width:14%;">Série</th>
                    <th style="width:16%;">Número</th>
                    <th></th>
                </tr>
                <tr>
                    <td rowspan="4" style="vertical-align:middle;">{{ $dados->ano ?? '' }}</td>
                    <td rowspan="4" style="vertical-align:middle;">{{ $dados->disticoSerie ?? '' }}</td>
                    <td rowspan="4" style="vertical-align:middle;">{{ $dados->disticoNumero ?? '' }}</td>
                    <td style="text-align:left;">Valor: {{ \App\Http\Utils::formatarComSeparador($dados->taxaValor ?? 0) }}</td>
                </tr>
                <tr>
                    <td style="text-align:left;">Impresso: {{ \App\Http\Utils::formatarComSeparador($dados->taxaImpresso ?? 0) }}</td>
                </tr>
                <tr>
                    <td style="text-align:left;">Juros: {{ \App\Http\Utils::formatarComSeparador($dados->taxaJuros ?? 0) }}</td>
                </tr>
                <tr>
                    <td style="text-align:left; font-weight:bold;">Total: {{ \App\Http\Utils::formatarComSeparador($dados->taxaTotal ?? 0) }}</td>
                </tr>
            </table>

            <div class="campo-linha" style="text-align:center; margin-top:10px;">
                Registo<br>
                Nº <span class="campo-valor">{{ $dados->registoNumero ?? '' }}</span>
            </div>

            <div class="campo-linha" style="text-align:center; margin-top:10px;">Câmara Municipal da Praia</div>

            <div class="campo-linha" style="text-align:center; margin-top:6px;">
                <span class="campo-valor" style="text-decoration:underline;">{{ $dados->dataRegisto ?? '' }}</span>
            </div>

            <div class="assinatura" style="text-align:center;">
                O Tesoureiro
                <span class="pontilhado"></span>
            </div>
        </td>
    </tr>
</table>

<footer>
    <table class="rodape-emissao">
        <tr>
            <td style="width:60%;">Declaração Produzida pelo Sistema Informático &nbsp; Cobrado Por: {{ $dados->cobradoPor ?? '' }}</td>
            <td style="width:40%; text-align:right;">{{ $dados->dataEmissao ?? '' }}</td>
        </tr>
    </table>

    <table class="rodape-pagamento" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width:32%;">
                <table width="100%">
                    <tr>
                        <td style="width:36px;">
                            <img src="{{ public_path('images/logo_sisp-01.png') }}" alt="vint4"
                                 style="width:32px; height:32px; display:block;">
                        </td>
                        <td>
                            <div style="font-weight:bold; font-size:8.5px;">Dados de Pagamento</div>
                            <div>Referência: {{ $dados->referencia ?? '' }}</div>
                            <div>Entidade: {{ $dados->entidade ?? '' }}</div>
                            <div>Valor: {{ \App\Http\Utils::formatarComSeparador($dados->taxaTotal ?? 0) }}</div>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="divisor" style="width:48%; text-align:center;">
                <div style="font-weight:bold;">Contra Prova/Validation Code:</div>
                <div class="validation-code">{{ '@' . ($dados->codigoBarra ?? '') . '@' }}</div>
                <div style="font-size:8px;">{{ $dados->codigoBarra ?? '' }}</div>
                <div style="font-size:7.5px; margin-top:2px;">Faça download do seu recibo indo para: www.lojacmp.com/autentica-recibo</div>
            </td>
            <td class="divisor" style="width:20%; text-align:center;">
                @if(!empty($qrcode_base64))
                    <img src="data:image/png;base64,{{ $qrcode_base64 }}" style="width:50px; height:50px;">
                @endif
            </td>
        </tr>
    </table>
</footer>

</body>
</html>
