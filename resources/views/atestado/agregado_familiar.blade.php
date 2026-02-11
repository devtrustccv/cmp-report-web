@extends('atestado.layouts.content')

@section('title', 'Atestado')

@section('content')
    <p> 
        Ao abrigo do Despacho nº 68/09 de 13 de Agosto, atesto a pedido do(a) interessado(a),
        registado no Sistema de Informação Municipal que, <strong>{{$assinatura->nome ?? ''}}</strong>, 
        {{$assinatura->estadoCivil ?? ''}},
       
        @if($assinatura->filiacao != null)
            {{$assinatura->filiacao ?? ''}}, 
        @endif

        @if($assinatura->naturalidade != null)
           natural de {{$assinatura->naturalidade ?? ''}},
        @endif
         
        portador(a) do {{$assinatura->tipoDocumento ?? ''}} 
        nº  {{$assinatura->numeroDocumento ?? ''}}, reside em {{$assinatura->residencia ?? ''}}
        @if($assinatura->agregado != null)
          tem o seu agregado familiar composto {{$assinatura->agregado ?? ''}}.
        @endif
        </p> 

    <p> O presente atestado serve para efeito de <strong>{{$assinatura->efeito ?? ''}}</strong>.</p> 

    <p> Por ser verdade e me ter sido pedido, mandei passar o presente atestado que 
        vai por mim assinado e devidamente autenticado com o código de barra 
        @{{$assinatura->codBarra}}@ em uso
         nesta Instituição.</p>

    <p>
        Cidade da Praia, {{ \Carbon\Carbon::parse($assinatura->dataRegisto)->translatedFormat('d \d\e F \d\e Y') }}.
    </p>
@endsection