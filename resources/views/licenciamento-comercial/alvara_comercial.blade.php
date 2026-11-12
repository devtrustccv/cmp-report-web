@extends('licenciamento-comercial.layout')

{{-- LICO_DA - Declaração de Alvará --}}
@php
    // ---- Parâmetros de formatação ----
    $fonte        = 'arial';
    $tamanhoFonte = '18px';
    $alturaLinha  = 1.6;

    /** @var \App\Models\CertidaoLicenciamentoDto $dados */
    $dataEmissao = \App\Models\CertidaoLicenciamentoDto::dataEmissaoExtenso();
@endphp

@section('title', 'Declaração Nº ' . $dados->nrCertidao)

@section('content')
    <div class="data-local">CMP, {{ $dataEmissao }}</div>

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
        <x-linha-preenchida>Válida para {{ $dados->finsTexto() }}.</x-linha-preenchida>
    @endif

    @if($dados->validadeTexto())
        <p>Válida por um período de {{ $dados->validadeTexto() }} meses.@preencher</p>
    @endif
@endsection
