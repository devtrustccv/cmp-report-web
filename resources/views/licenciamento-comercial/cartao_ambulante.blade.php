@extends('licenciamento-comercial.layout')

{{-- LICO_DC - Declaração de Cartão (Ambulante) --}}
@php
    // ---- Parâmetros de formatação ----
    $fonte        = 'arial';
    $tamanhoFonte = '18px';
    $alturaLinha  = 1.9;

    /** @var \App\Models\CertidaoLicenciamentoDto $dados */
    $dataEmissao = \App\Models\CertidaoLicenciamentoDto::dataEmissaoExtenso();
@endphp

@section('title', 'Declaração Nº ' . $dados->nrCertidao)

@section('content')
    <div class="data-local">Câmara Municipal da Praia, {{ $dataEmissao }}</div>

    <div class="titulo-documento" style="text-decoration: none;">Declaração Nº{{ $dados->nrCertidao }}</div>

    <p>
        @iguais(5) Para os devidos efeitos, declara que {!! $dados->titularesTexto() !!},
        {{ $dados->conforme('é titular', 'são titulares') }} do Cartão Ambulante registado sob
        <strong>{{ $dados->nrCartao }}</strong>@preencher
    </p>

    <p>
        Por ser verdade, passa a presente declaração, que vai devidamente assinada e autenticada com
        carimbo a óleo em uso nesta Instituição.@preencher
    </p>

    <x-linha-preenchida><span class="italico">Válido para {{ $dados->finsTexto() }}</span></x-linha-preenchida>

    @if($dados->validadeTexto())
        <x-linha-preenchida>Válido por um período de {{ $dados->validadeTexto() }} meses.</x-linha-preenchida>
    @endif
@endsection
