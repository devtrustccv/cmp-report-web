@extends('duc.layout')

@section('content')

 @include('components.watermark', ['estado' => $dados->estado ?? "REQ_PAG"])

<table width="100%" cellspacing="0" cellpadding="0"
       style="margin-top:10px; border:1px solid #000;">
    <tr>
        <td style="padding:6px;">
 <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
    <tr>
        <td style="width:25%; padding:3px 3px;"><strong>{{$dados->tipoDuc ?? ''}} :</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->dividaComprador ?? 0) }} </span> </td>
        <td style="width:25%; padding:3px 3px;"><strong>Multa :</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->multa ?? 0)}}</span> </td>
        <td style="width:25%; padding:3px 3px;"><strong>Juros :</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->juro ?? 0)}}</span>  </td>
    </tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
    <tr>
        <td style="width:100%; padding:3px 3px;"> <strong>Total Pago :</strong> <span style="text-decoration: underline;">
            {{\App\Http\Utils::formatarComSeparador($dados->total_pago ?? 0) }}
              </span> <span>({{$dados->totalExtenso ?? ''}})</span> </td>
    </tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
    <tr>
        <td style="width:25%; padding:3px 3px;"><strong>Valor Avaliado :</strong> <span style="text-decoration: underline;">
            {{\App\Http\Utils::formatarComSeparador($dados->valor_avalidado  ?? 0) }} 
           </span> </td>
        <td style="width:25%; padding:3px 3px;"><strong>Valor Declarado :</strong><span style="text-decoration: underline;">
            {{\App\Http\Utils::formatarComSeparador($dados->valor_declarado ?? 0) }}</span>   </td>
        <td style="width:25%; padding:3px 3px;"><strong>Área :</strong> <span style="text-decoration: underline;">{{$dados->area ?? ''}} </span> m²</td>
    </tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
     <tr>
        <td style="width:100%; padding:3px 3px;"> <strong>Comprador :</strong><span style="text-decoration: underline;">{{ $dados->comprador ?? '' }}</span>  </td>
    </tr>
     <tr>
        <td style="width:100%; padding:3px 3px;"> <strong>Vendedor :</strong> <span style="text-decoration: underline;">{{  $dados->vendedor ?? ''}}</span> </td>
    </tr>
</table>
 </td>
    </tr>
</table>
<h4>Descrição:</h4>
<p style="
    border:1px solid #000;
    min-height:40px;
    padding:8px;
    margin-top:12px;
    margin-12px;
    margin-bottom:80px; 
    text-align: justify;
    word-wrap: break-word;
    overflow-wrap: break-word;
">
    <!-- espaço para assinatura ou texto -->
    {{$dados -> descricao ?? '' }}
</p>

@endsection
