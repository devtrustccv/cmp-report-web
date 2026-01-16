<hr>
<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;  border:1px solid #000;">
    <tr>
        <td style="font-size: 10px; width:42%; padding:6px 8px;"> <strong>Data Emissão :</strong> {{$dados->data_emissao ?? ''}} </td>
        <td style="font-size: 10px; width:58%; padding:6px 8px;"> <strong>Emitido Por :</strong> {{$dados->emitido_por ?? ''}} </td>
    </tr>
    <tr>
        <td style="font-size: 10px; width:42%; padding:6px 8px;"><strong>Data Pagamento :</strong> {{$dados->data_pagamento ?? ''}} </td>
        <td style="font-size: 10px; width:58%; padding:6px 8px;"><strong>Cobrado Por:</strong> {{$dados->cobrado_por?? ''}}  </td>
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
        <td align="center" style="border:1px solid #000; padding:6px 8px;">
            <div><strong>Contra Prova/Validation Code:</strong></div>
            <div><strong>{{$dados->codigoBarra}}</strong></div>
        </td>
    </tr>
</table>
<div style="font-size:7px;">www.lojacmp.com/autentica-recibo <strong>Contact Center:</strong> 8005002</div>
