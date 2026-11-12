@extends('licenciamento-comercial.layout')

{{-- LICO_DC - Declaração de Cartão (Ambulante) --}}
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

    <div class="titulo-documento" style="text-decoration: none;">Declaração Nº{{ $dados->nrCertidao }}</div>

    <p>
        @iguais Para os devidos efeitos, declara que {!! $dados->titularesTexto() !!},
        {{ $dados->conforme('é portadora', 'são portadores') }} do Cartão Ambulante registado sob
        <strong>{{ $dados->nrCartao }}</strong>@preencher
    </p>

    <p>
        Por ser verdade, passa a presente declaração, que vai devidamente assinada e autenticada com
        carimbo a óleo em uso nesta Instituição.@preencher
    </p>

    @if($dados->finsTexto())
        <p class="italico negrito">Válido para {{ $dados->finsTexto() }}.@preencher</p>
    @endif

    @if($dados->validadeTexto())
        <p class="negrito">Válido por um período de {{ $dados->validadeTexto() }} meses.@preencher</p>
    @endif

    <p class="italico">Praia, <span class="data-emissao">{{ $dataEmissao }}.</span></p>
@endsection
