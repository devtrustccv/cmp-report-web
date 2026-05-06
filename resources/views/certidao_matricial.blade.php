<html>
<head>
    <style>
        @page {
            margin: 100px 50px 50px 50px;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            text-align: center;
        }

        .header img {
            width: 40px;
            height: 40px;
            display: block;
            margin: 0 auto;
        }

        .header .title {
            font-size: 14px;
            margin-top: 5px;
        }

        .content {
            width: 100%;
        }

        .item {
            page-break-inside: avoid;
            margin-bottom: 15px;
        }

        .duc-box {
                width: 100%;
                border: 1px solid #000;
                font-family: Arial, sans-serif;
                font-size: 10px;
                border-collapse: collapse;
            }

            .duc-left {
                width: 38%;
                border-right: 2px solid #000;
                padding: 6px;
                vertical-align: top;
            }

            .duc-right {
                width: 62%;
                padding: 6px;
                vertical-align: top;
            }

            .title {
                font-weight: bold;
                font-size: 11px;
            }

            .row {
                width: 100%;
                margin-top: 5px;
            }

            .label {
                display: inline-block;
                width: 85px;
            }

            .value {
                float: right;
                text-align: right;
            }

            .line {
                border-top: 1px solid #000;
                margin: 8px 0 2px 90px;
            }

            .center {
                text-align: center;
            }

            .barcode-text {
                font-size: 16px;
                font-weight: bold;
                text-align: center;
                margin-top: 5px;
            }

            .small {
                font-size: 8px;
                font-weight: bold;
            }

            .right-line {
                border-top: 1px solid #000;
                width: 75%;
                margin-left: auto;
                margin-top: 18px;
            }
             .footer {
                position: fixed;
                bottom: 5px; /* ajusta conforme altura */
                left: 0;
                right: 0;
            }
    </style>
</head>
<body>

     {{-- WATERMARK --}}
    @include('components.watermark', ['estado' => $dados->estadoDuc ?? 'REQ_PAG'])

    <div class="header">
        <img src="{{ public_path('images/logo_CMPRAIA.png') }}">
        <div class="title">Câmara Municipal da Praia</div>
        <div class="title">CERTIDÃO MATRICIAL</div>
    </div>

    <div class="content">
       <div style="
                    border:1px solid #000;
                    min-height:680px;
                    padding:8px;
                    margin-top:30px;
                    margin-12px;
                    margin-bottom:80px; 
                    text-align: justify;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                ">
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                <tr>
                    <td style="width:20%; padding:3px 3px;"> <strong style="font-size:12px;">Nº </strong><span style="font-size:12px;">{{$dados->certidao ?? ""}}/{{$dados->ano ?? ""}}</span>  </td>
                    <td style="width:55%; padding:3px 3px;"> <strong style="font-size:12px;">Para efeito de: </strong><span style="font-size:12px;">{{$dados->efeito ?? ""}}</span>  </td>
                    <td style="width:20%; padding:3px 3px;"></td>
                </tr>
                <tr>
                    <td colspan="3" style="width:100%; padding:3px 3px;"> <strong style="font-size:12px;">Requerente :</strong> <span style="font-size:12px;">{{$dados->requerente ?? ""}}</span> </td>
                </tr>
            </table>
            <div style="
                    border:1px solid #000;
                    min-height:10px;
                    padding:8px;
                    margin-bottom:5px;
                    margin-top:5px;
                    margin-12px;
                    text-align: justify;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                ">
                <span style="font-size:12px;">
                    <strong>
                        TITULAR: {{$dados->categoria ?? ""}}
                    </strong>
                </span>
            </div>
            <div style="
                    border:1px solid #000;
                    min-height:10px;
                    padding:8px;
                    margin-top:5px;
                    margin-12px;
                    text-align: justify;
                    word-wrap: break-word;
                    overflow-wrap: break-word;
                ">
                <span style="font-size:12px;">
                    <strong>Nome: </strong>{{$dados->proprietario ?? ""}}
                </span>
            </div>
            <span style="font-size:12px;"><strong>INFORMAÇÃO MATRICIAL</strong></span><br>
            <span style="font-size:12px;"><strong>Tipo Prédio: </strong>{{$dados->tipoPredio ?? ""}}</span><br>
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                <tr>
                    <td style="width:25%; padding:3px 3px;"><strong style="font-size:12px;">Matriz: </strong><span style="font-size:12px;">{{$dados->tipo ?? ""}}</span>  </td>
                    <td style="width:15%; padding:3px 3px;"><strong style="font-size:12px;">Nº: </strong><span style="font-size:12px;">{{$dados->numMatriz ?? ""}}/{{$dados->fraccao ?? ""}}</span>  </td>
                    <td style="width:35%; padding:3px 3px;"><strong style="font-size:12px;">Freguesia: </strong><span style="font-size:12px;">{{$dados->freguesia ?? ""}}</span> </td>
                    <td style="width:35%; padding:3px 3px;"><strong style="font-size:12px;">Localização: </strong><span style="font-size:12px;">{{$dados->local ?? ""}}</span> </td>
                </tr>
            </table>
            <span style="font-size:12px;"><strong>Confrontações</strong></span><br>
            <ul style=" font-size:12px; list-style: none; padding-left: 20px; font-style: italic;">
                <li style="margin-bottom:5px;">Norte: {{$dados->norte ?? ""}}</li>
                <li style="margin-bottom:5px;">Sul: {{$dados->sul ?? ""}}</li>
                <li style="margin-bottom:5px;">Este: {{$dados->este ?? ""}}</li>
                <li style="margin-bottom:5px;">Oeste: {{$dados->oeste ?? ""}}</li>
            </ul>
            <span style="font-size:12px;"><strong>Área: </strong>{{$dados->superficie ?? ""}}</span><br>
            <span style="font-size:12px;"><strong>Valor Matricial: </strong>{{\App\Http\Utils::formatarComSeparador($dados->rendimento) ?? ""}} $00 {{$dados->rendExt ?? ""}}</span>
            <br><br>
            <span style="font-size:12px; margin-top:10px;"><strong>Descrição: </strong></span><br>
            <p style="font-size:10px;">
                    {{$dados->descricao ?? ""}}
            </p>

            @if(!empty($dados->quoataDesc))
                <span style="font-size:12px;"><strong>Quaota: </strong></span><br>
                <p>{{ $dados->quoataDesc }}</p>
            @endif

        </div>
    </div>
    <div class="footer">
        <table class="duc-box">
            <tr>
                <td class="duc-left">
                    <div class="title">
                        CONTA - DUC {{$dados->duc ?? ''}}
                    </div>

                    <br>

                    @foreach($dados->emolumentos as $item)
                        <div class="row">
                            <span class="label">{{ $item->codigo }}</span>
                            <span class="value">
                                {{ \App\Http\Utils::formatarComSeparador($item->valor ?? 0) }}
                            </span>
                        </div>
                    @endforeach

                    <div class="line"></div>

                    <div class="row">
                        <span class="label">Total .................</span>
                        <span class="value">{{\App\Http\Utils::formatarComSeparador($dados->totalEmolumentos)}}</span>
                    </div>
                </td>

                <td class="duc-right">
                    <div class="title">EMISSÃO</div>

                    <div style="margin-top:4px;">
                        Emitido por: {{$dados->utilizador}}
                    </div>

                    <div style="margin-top:12px;">
                        Em:  {{$dados->dataEmissao}}
                    </div>

                    <div class="right-line"></div>

                    <table style="width:100%; margin-top:2px; font-size:8px; font-weight:bold;">
                        <tr>
                            <td>Cobrado por: {{$dados->cobradoPor}}</td>
                            <td style="text-align:right;">{{$dados->dataCobranca}}</td>
                        </tr>
                    </table>

                    <div class="center small">
                        Contra Prova/Validation Code:
                    </div>

                    <div class="barcode-text">
                      {{$dados->codigoBarra}}
                    </div>
                </td>
            </tr>
        </table>
<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
    <tr>
        <td style="width:10%;">
             <img src="{{ public_path('images/logo_sisp-01.png') }}" alt="Logo Município" 
        style="width:50px !important; height:50px !important; display:block; margin:0 auto 5px auto;">
        </td>
        <td style="font-size: 10px; width:20%;">
            <div style="margin-bottom:5px;"><strong>Entidade: </strong> 112</div>
            <div style="margin-bottom:5px;"><strong>Referencia: </strong>{{$dados->duc ?? ''}}</div>
            <div style="margin-bottom:5px;"><strong>Valor: </strong>{{\App\Http\Utils::formatarComSeparador($dados->totalEmolumentos)}}
            </div>
        </td>
        <td align="center width:20%; text-align:center;">
            <span style="font-size:12px;">
                Certidão processada por computador e autenticada com o código de barras.Declaro ter lido e efetuado o presente pagamento.
           </span>      
        </td>
        <td style="text-align: right; width:20%;">
            <img src="data:image/png;base64, {{ $qrcode_base64 }}" alt="QR Code"
            style="width:50px; height:50px;">
        </td>

    </tr>
</table>
<span style="font-size:10px;">Faça download do seu recibo indo para: www.lojacmp.com/autentica-recibo</span>
            <span style="font-size:10px;">Contact Center: 8005002</span>    
    </div>

</body>
</html>