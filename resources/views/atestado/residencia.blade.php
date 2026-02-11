@extends('atestado.layouts.content')

@section('title', 'Atestado')

@section('content')
    <p> Ao abrigo da Deliberação nº 33/18 de 12 de Julho, atesto a pedido do(a) interessado(a),
         registado no Sistema de Informação Municipal que, <strong>{{$assinatura->nome ?? ''}}</strong>,  {{ $assinatura->estadoCivil ?? '' }},
        {{$assinatura->filiacao ?? ''}}, 
        natural de {{ $assinatura->naturalidade ?? '' }}, portador(a) do {{$assinatura->tipoDocumento ?? ''}} 
        nº  {{$assinatura->numeroDocumento ?? ''}}, reside em {{ $assinatura->residencia ?? '' }}.
    </p>
    <p>O presente atestado serve para efeito de <strong>{{ $assinatura->efeito ?? '' }}</strong>.</p>
    <p>Por ser verdade e me ter sido pedido, mandei passar o presente atestado que vai por mim assinado e devidamente autenticado com o código de barra em uso nesta Instituição.</p>
    <p>
        Cidade da Praia, {{ \Carbon\Carbon::parse($assinatura->dataRegisto)->translatedFormat('d \d\e F \d\e Y') }}.
    </p>
    
@endsection