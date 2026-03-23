@extends('layout')

@section('content')

@include('components.watermark', ['estado' => $dados->estado ?? "REQ_PAG"])
 <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:10px;">
    <tr>
        <td style="width:50%; padding:6px 8px;"><strong>{{$dados->tipoDuc ?? ''}} :</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->total_pago ?? 0) }} </span> </td>
        <td style="width:50%; padding:6px 8px;"><strong>Juros :</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->juro ?? 0)}}</span>  </td>
    </tr>
     <tr>
        <td style="width:100%; padding:6px 8px;"><strong>TOTAL Pago :</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->total_pago ?? 0)}}</span> <span style="font-size:10px;">({{$dados->totalExtenso}})</span> </td>
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
        <td>
            <strong>Valor da Remição: </strong><span>{{\App\Http\Utils::formatarComSeparador($dados->remiTaxa ?? 0)}}</span>
        </td>
      </tr>
</table>

<div style="
    border:1px solid #000;   
    min-height:60px;        
    padding:8px;             
    margin-top:12px;        
    text-align: justify;
">
    <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
        <tr>
            <td>
                <strong>
                    Nome:
                </strong> <span style="text-decoration: underline;">{{$dados->remiRequerente ?? ''}}</spam> 
            </td>
            <td>
                <strong> BI/Passaporte:</strong>  <span style="text-decoration: underline;"></spam> 
            </td>
        </tr>
        <tr>
            <td>
                <strong> Morada : </strong> <span style="text-decoration: underline;">{{$dados->remiResidencia ?? ''}}</spam> 
            </td>
        </tr>
        <tr>
            <td>
                <strong> Vendedor:  </strong> <span style="text-decoration: underline;">DOCUMENTO SO PARA USO INTERNO DO MUNICIPIO</spam> 
            </td>
        </tr>
        
        
    </table>
</div>

<strong style="margin-top: 4px;">Informações da Matriz:</strong>
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
                <strong>Local:</strong><span style="text-decoration: underline;">{{$dados->localizacao ?? ''}}</span>
            </td>
            <td>
                <strong>Lote:</strong><span style="text-decoration: underline;">{{$dados->refCadastral ?? ''}}</span>
            </td>
            <td>
                <strong>Área:</strong><span style="text-decoration: underline;">{{$dados->area ?? ''}}</span>
            </td>
        </tr>
        
    </table>
</div>

<strong style="margin-top: 4px;">Descrição:</strong>
<p style="
    border:1px solid #000;   
    min-height:50px;        
    padding:8px;             
    margin-top:12px;   
    font-size:12px;     
    text-align: justify;
">
    <!-- espaço para assinatura ou texto -->
    {{$dados -> descricao ?? '' }}
</p>

@endsection