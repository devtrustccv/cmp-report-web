@extends('licenciamento-comercial.layout')

{{-- LICO_DA - Declaração de Alvará --}}
@php
    // ---- Parâmetros de formatação ----
    $fonte        = 'times'; // Times New Roman
    $tamanhoFonte = '1.2rem'; // 20px
    $alturaLinha  = 1.4;       // espaço entre as linhas de um parágrafo
    $corTexto     = '#333333';
    view()->share(compact('fonte', 'tamanhoFonte')); // o <x-linha-preenchida> mede com a mesma fonte

    /** @var \App\Models\CertidaoLicenciamentoDto $dados */
    $dataEmissao = \App\Models\CertidaoLicenciamentoDto::dataEmissaoExtenso();
@endphp

@section('title', 'Declaração Nº ' . $dados->nrCertidao)

@section('content')
    <div class="titulo-documento">Declaração Nº{{ $dados->nrCertidao }}</div>

    <p>
        @iguais Para os devidos efeitos, declara que {!! $dados->titularesTexto() !!},
        {{ $dados->conforme('é portadora', 'são portadores') }} do Alvará Comercial registado sob o
        <strong>Nº {{ $dados->nAlvara }}</strong>@preencher
    </p>

    <p>
        Por ser verdade, passa a presente declaração que vai devidamente assinada e autenticada com
        carimbo a óleo em uso nesta Instituição.@preencher
    </p>

    <div class="espaco"></div>

    @if($dados->finsTexto())
        <p class="italico negrito">Válida para {{ $dados->finsTexto() }}.@preencher</p>
    @endif

    @if($dados->validadeTexto())
        <p class="negrito">Válida por um período de {{ $dados->validadeTexto() }} meses.@preencher</p>
    @endif

    <p class="italico">Praia, <span class="data-emissao">{{ $dataEmissao }}.</span></p>
@endsection
