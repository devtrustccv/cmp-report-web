@extends('layout')

@section('content')
<table width="100%" cellspacing="0" cellpadding="0"
       style="margin-top:30px; border:1px solid #000;">
    <tr>
        <td style="padding:6px;">
 <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;">
    <tr>
        <td style="width:25%; padding:6px 8px;"><strong>IUP :</strong> <span style="text-decoration: underline;">{{$dados->iup ?? ''}} </span> </td>
        <td style="width:25%; padding:6px 8px;"><strong>Multa :</strong> <span style="text-decoration: underline;">{{$dados->multa ?? ''}}</span> </td>
        <td style="width:25%; padding:6px 8px;"><strong>Juros :</strong> <span style="text-decoration: underline;">{{$dados->juros ?? ''}}</span>  </td>
    </tr>
</table>



<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;">
    <tr>
        <td style="width:100%; padding:6px 8px;"> <strong>Total Pago :</strong> <span style="text-decoration: underline;">{{$dados->total_pago ?? ''}} </span> </td>
    </tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;">
    <tr>
        <td style="width:25%; padding:6px 8px;"><strong>Valor Avaliado :</strong> <span style="text-decoration: underline;">{{$dados->valor_declarado ?? ''}}</span> </td>
        <td style="width:25%; padding:6px 8px;"><strong>Valor Declarado :</strong><span style="text-decoration: underline;">{{$dados->valor_declarado ?? ''}}</span>   </td>
        <td style="width:25%; padding:6px 8px;"><strong>Área :</strong> <span style="text-decoration: underline;">{{$dados->area ?? ''}}</span>  </td>
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
<h4>Descrição</h4>
<p style="
    border:1px solid #000;   /* borda do retângulo */
    min-height:60px;         /* altura mínima */
    padding:8px;             /* espaço interno */
    margin-top:12px;         /* distância do conteúdo acima */
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
