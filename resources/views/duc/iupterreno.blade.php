@extends('duc.layout')

@section('content')

@include('components.watermark', ['estado' => $dados->estado ?? "REQ_PAG"])
 <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;">
    <tr>
        <td style="width:50%; padding:6px 1px;"><strong>IUP :</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->sisa ?? 0) }} </span> </td>
        <td style="width:50%; padding:6px 1px;"><strong>Juros :</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->juro ?? 0)}}</span>  </td>
    </tr>
     <tr>
        <td style="width:100%; padding:6px 1px;"><strong>TOTAL Pago : </strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->total_pago ?? 0)}}</span> <span style="font-size:10px;">{{$dados->estenso??''}}</span> </td>
    </tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0"
       style="margin-top:10px; border:none;">
      <tr>
         <td>
            <strong>
                Informações do Comprador  
            </strong>
        </td>
      </tr>
      <tr>
        <td style="width:50%; padding:6px 8px;">
            <strong>Nome: </strong><span style="text-decoration: underline; font-size:12px;">{{$dados->nomeRequerente ?? ''}}</span>
        </td>
        <td style="width:50%; padding:6px 8px;">
            <strong>Valor da Compra: </strong><span style="text-decoration: underline; font-size:12px;">{{\App\Http\Utils::formatarComSeparador($dados->totalOnline ?? 0)}}</span>
        </td>
      </tr>
      <tr>
        <td style="width:50%; padding:6px 8px;">
            <strong>Morada: </strong><span style="text-decoration: underline; font-size:12px;">{{$dados->morada ?? ''}}</span>
        </td>
        <td style="width:50%; padding:6px 8px;">
            <strong>BI/Passaporte: </strong><span style="text-decoration: underline; font-size:12px;">{{$dados->bi ?? ''}}</span>
        </td>
      </tr>
      <tr>
        <td style="width:100%; padding:6px 8px;">
            <strong>Vendedor: DOCUMENTO SO PARA USO INTERNO DO MUNICIPIO</strong>
        </td>
      </tr>
</table>



<strong style="margin-top: 4px;">Informações do Terreno:</strong>
<div style="
    border:1px solid #000;   
    min-height:20px;        
    padding:8px;             
    margin-top:12px;        
    text-align: justify;
">
    <table  width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
        <tr>
            <td>
                <strong>Local: </strong><span style="text-decoration: underline; font-size:12px;">{{$dados->local ?? ''}}</span>
            </td>
            <td>
                <strong>Medições: </strong><span style="text-decoration: underline; font-size:12px;">{{$dados->superficie ?? ''}} m2</span>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Norte: </strong><span style="text-decoration: underline; font-size:12px;">{{$dados->norte ?? ''}}</span>
            </td>
            <td>
                <strong>Este: </strong><span style="text-decoration: underline; font-size:12px;">{{$dados->este ?? ''}}</span>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Sul: </strong><span style="text-decoration: underline; font-size:12px;">{{$dados->sul ?? ''}}</span>
            </td>
            <td>
                <strong>Oeste: </strong><span style="text-decoration: underline; font-size:12px;">{{$dados->oeste ?? ''}}</span>
            </td>
        </tr>
        
    </table>
</div>

<strong style="margin-top: 4px;">Descrição:</strong>
<p style="
    border:1px solid #000;   
    min-height:30px;        
    padding:8px;             
    margin-top:12px;   
    font-size:12px;     
    text-align: justify;
">
    <!-- espaço para assinatura ou texto -->
    {{$dados -> descricao ?? '' }}
</p>

@endsection