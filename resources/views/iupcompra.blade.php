@extends('layout')

@section('content')

 @include('components.watermark', ['estado' => $dados->estado ?? "REQ_PAG"])

<table width="100%" cellspacing="0" cellpadding="0"
       style="margin-top:30px; border:1px solid #000;">
    <tr>
        <td style="padding:6px;">
 <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;">
    <tr>
        <td style="width:25%; padding:6px 8px;"><strong>IUP :</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->total_pago ?? 0) }} </span> </td>
        <td style="width:25%; padding:6px 8px;"><strong>Multa :</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->multa ?? 0)}}</span> </td>
        <td style="width:25%; padding:6px 8px;"><strong>Juros :</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->juro ?? 0)}}</span>  </td>
    </tr>
</table>



<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;">
    <tr>
        <td style="width:100%; padding:6px 8px;"> <strong>Total Pago :</strong> <span style="text-decoration: underline;">
            {{\App\Http\Utils::formatarComSeparador($dados->total_pago ?? 0) }}
              </span> <span>({{$dados->extenso}})</span> </td>
    </tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;">
    <tr>
        <td style="width:25%; padding:6px 8px;"><strong>Valor Avaliado :</strong> <span style="text-decoration: underline;">
            {{\App\Http\Utils::formatarComSeparador($dados->valor_avalidado  ?? 0) }} 
           </span> </td>
        <td style="width:25%; padding:6px 8px;"><strong>Valor Declarado :</strong><span style="text-decoration: underline;">
            {{\App\Http\Utils::formatarComSeparador($dados->valor_declarado ?? 0) }}</span>   </td>
        <td style="width:25%; padding:6px 8px;"><strong>Área :</strong> <span style="text-decoration: underline;">{{$dados->area ?? ''}} </span> m²</td>
    </tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;">
     <tr>
        <td style="width:100%; padding:6px 8px;"> <strong>Comprador :</strong><span style="text-decoration: underline;">{{ $dados->comprador ?? '' }}</span>  </td>
    </tr>
     <tr>
        <td style="width:100%; padding:6px 8px;"> <strong>Vendedor :</strong> <span style="text-decoration: underline;">{{  $dados->vendedor ?? ''}}</span> </td>
    </tr>
</table>
 </td>
    </tr>
</table>
<h4>Descrição:</h4>
<p style="
    border:1px solid #000;   
    min-height:60px;        
    padding:8px;             
    margin-top:12px;        
    text-align: justify;
">
    <!-- espaço para assinatura ou texto -->
    {{$dados -> descricao }}
</p>


<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:40px;">
    <tr>
        <td style="width:50%; text-align:center;">
            O Tesoureiro
            <br><br><br> <!-- espaço para assinatura -->
            <span style="border-top:1px solid #000; display:inline-block; width:200px;"></span>
        </td>
    </tr>
</table>



@endsection
