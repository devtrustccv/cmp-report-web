@extends('licenciamento-comercial.layout')

{{-- Certidão sem Alvará (ainda sem código na API; dados vêm todos do CertidaoLicenciamentoDto) --}}
@php
    // ---- Parâmetros de formatação ----
    $fonte        = 'arial';
    $tamanhoFonte = '18px';
    $alturaLinha  = 1.5;

    /** @var \App\Models\CertidaoLicenciamentoDto $dados */
@endphp

@section('title', 'Certidão Nº ' . $dados->nrCertidao)

@section('content')
    <div class="titulo-documento">CERTIDÃO Nº {{ $dados->nrCertidao }}</div>

    <p class="italico">
        @iguais(10)Certifico, de harmonia com o requerimento de {!! $dados->titularesTexto() !!},
        e em cumprimento do despacho no mesmo exarado que, compulsando o cadastro
        comercial existente neste serviço, não se encontra registado nenhum Alvará/licença comercial,
        licenciado em nome da mesma.@preencher
    </p>

    <p class="italico">
        @iguais(10) Por ser verdade, mandei passar a presente certidão, que dato e assino e faço autenticar com
        carimbo a óleo em uso neste serviço.@preencher
    </p>

    <div class="espaco"></div>

    @if($dados->finsTexto())
        <x-linha-preenchida italico>Válido para {{ $dados->finsTexto() }}.</x-linha-preenchida>
    @endif

    @if($dados->validadeTexto())
        <p class="italico">Valida por um período de {{ $dados->validadeTexto() }} meses.@preencher</p>
    @endif

     <p class="italico">CÂMARA MUNICIPAL DA PRAIA, {{ $dataEmissao }}.</p>
@endsection
