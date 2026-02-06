<hr>
<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;  border:1px solid #000;">
    <tr>
        <td style="font-size: 10px; width:42%; padding:3px 6px;"> <strong>Data Emissão :</strong> {{$dados->data_emissao ?? ''}} </td>
        <td style="font-size: 10px; width:58%; padding:3px 6px;"> <strong>Emitido Por :</strong> {{$dados->emitido_por ?? ''}} </td>
    </tr>
    <tr>
        <td style="font-size: 10px; width:42%; padding:3px 6px;"><strong>Data Pagamento :</strong> {{$dados->data_pagamento ?? ''}} </td>
        <td style="font-size: 10px; width:58%; padding:3px 6px;"><strong>Cobrado Por:</strong> {{$dados->cobrado_por?? ''}}  </td>
    </tr>
    <tr>
        <td style="font-size: 10px; width:42%; padding:3px 6px;"> </td>
        <td style="font-size: 10px; width:58%; padding:3px 6px;"><strong>Meio Pagamento:</strong> {{$dados->meioPagamento ?? ''}}  </td>
    </tr>
</table>
<table width="100%">
    <tr>
        <td>
             <img src="{{ public_path('images/logo_sisp-01.png') }}" alt="Logo Município" 
        style="width:50px !important; height:50px !important; display:block; margin:0 auto 5px auto;">
        </td>
        <td style="font-size: 10px;">
            <div><strong>Entidade :</strong> 112</div>
            <div><strong>Referencia :</strong>{{$dados->duc ?? ''}}</div>
            <div><strong>Valor :</strong>{{\App\Http\Utils::formatarComSeparador($dados->total_pago ?? 0) }}
            </div>
        </td>
        <td align="center" style="border:1px solid #000; padding:3px 6px;">
            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                <div>
                    <div><strong>Contra Prova/Validation Code:</strong></div>
                    <div><strong>{{ $dados->codigoBarra ?? '' }}</strong></div>
                </div>
                  
            </div>
        </td>
        <td>
            <img src="data:image/png;base64, {{ $qrcode_base64 }}" alt="QR Code">
        </td>

    </tr>
</table>
<div style="font-size:7px;">www.lojacmp.com/autentica-recibo <strong>Contact Center:</strong> 8005002</div>
