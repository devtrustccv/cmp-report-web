@extends('licenciamento-comercial.layout')

{{-- LICO_ECVA - Encerramento de Cartão Venda Ambulante (modelo Certidão) --}}
@php
    // ---- Parâmetros de formatação ----
    $fonte        = 'arial';
    $tamanhoFonte = '18px';
    $alturaLinha  = 1.5;

    /** @var \App\Models\CertidaoLicenciamentoDto $dados */
    $dataEmissao = mb_strtoupper(\App\Models\CertidaoLicenciamentoDto::dataEmissaoExtenso());
@endphp

@section('title', 'Certidão Nº ' . $dados->nrCertidao)

@section('content')
    <div class="titulo-documento">CERTIDÃO Nº {{ $dados->nrCertidao }}</div>

    <p class="italico">
        @preencher Certifico, de harmonia com o requerimento de {!! $dados->titularesTexto() !!},
        e em cumprimento do despacho no mesmo exarado que, compulsando o cadastro comercial existente
        neste serviço, não se encontra registado nenhum Alvará/licença comercial,
        <span style="font-style: normal;">licenciado em nome da mesma.</span>@preencher
    </p>

    <p class="italico">
        Por ser verdade, mandei passar a presente certidão, que dato e assino e faço autenticar com
        carimbo a óleo em uso neste serviço.
    </p>

    <div class="espaco"></div>

    <p class="negrito centro">
       @preencher <span class="italico" style="font-weight: normal;">Válido para {{ $dados->finsTexto() }}</span> @preencher
    </p>

    @if($dados->validadeTexto())
        <p class="italico">@preencher Valida por um período de {{ $dados->validadeTexto() }} meses. @preencher</p>
    @endif

    <div class="espaco"></div>

    <p class="italico">CÂMARA MUNICIPAL DA PRAIA, {{ $dataEmissao }}.</p>
@endsection
