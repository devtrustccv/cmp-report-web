@extends('licenciamento-comercial.layout')

{{-- LICO_DA - Declaração de Alvará --}}
@php
    // ---- Parâmetros de formatação ----
    $fonte        = 'lora';
    $tamanhoFonte = '1.2rem'; // 20px
    $alturaLinha  = 1.8;       // dá respiro entre as linhas
    $corTexto     = '#333333';
    view()->share(compact('fonte', 'tamanhoFonte')); // o <x-linha-preenchida> mede com a mesma fonte

    /** @var \App\Models\CertidaoLicenciamentoDto $dados */
    $dataEmissao = \App\Models\CertidaoLicenciamentoDto::dataEmissaoExtenso();
@endphp

@section('title', 'Declaração Nº ' . $dados->nrCertidao)

@section('content')
    <div class="titulo-documento">Declaração Nº{{ $dados->nrCertidao }}</div>

    <p>
        Para os devidos efeitos, declara que {!! $dados->titularesTexto() !!},
        {{ $dados->conforme('é portadora', 'são portadores') }} do Alvará Comercial registado sob o
        <strong>nº{{ $dados->nAlvara }}</strong>@preencher
    </p>

    <p>
        Por ser verdade, passa a presente declaração que vai devidamente assinada e autenticada com
        carimbo a óleo em uso nesta Instituição.@preencher
    </p>

    <div class="espaco"></div>

    @if($dados->finsTexto())
        <p class="italico">Válida para {{ $dados->finsTexto() }}.</p>
    @endif

    @if($dados->validadeTexto())
        <p>Válida por um período de {{ $dados->validadeTexto() }} meses.@preencher</p>
    @endif

    <p class="italico">Praia, {{ $dataEmissao }}.</p>
@endsection
