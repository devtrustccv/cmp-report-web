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
    <div class="data-local">Câmara Municipal da Praia, {{ $dataEmissao }}</div>

    <div class="titulo-documento">Declaração Nº{{ $dados->nrCertidao }}</div>

    <p>
        Para os devidos efeitos, declara que {!! $dados->titularesTexto() !!},
        {{ $dados->conforme('é titular', 'são titulares') }} do Alvará Comercial registado sob o
        <strong>nº{{ $dados->nAlvara }}</strong>@preencher
    </p>

    <p>
        Por ser verdade, passa a presente declaração que vai devidamente assinada e autenticada com
        carimbo a óleo em uso nesta Instituição.@preencher
    </p>

    <div class="espaco"></div>

    <p>@preencher Válida para {{ $dados->finsTexto() }}.@preencher</p>

    @if($dados->validadeTexto())
        <p>@preencher Válida por um período de {{ $dados->validadeTexto() }} meses. @preencher</p>
    @endif
@endsection
