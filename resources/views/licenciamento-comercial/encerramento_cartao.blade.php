@extends('licenciamento-comercial.layout')

{{-- LICO_ECVA - Encerramento de Cartão de Vendedor Ambulante --}}
@php
    // ---- Parâmetros de formatação ----
    $fonte        = 'arial';
    $tamanhoFonte = '18px';
    $alturaLinha  = 1.6;

    /** @var \App\Models\CertidaoLicenciamentoDto $dados */
    $dataEmissao = \App\Models\CertidaoLicenciamentoDto::dataEmissaoExtenso();
@endphp

@section('title', 'Encerramento de Cartão nº ' . $dados->nrCertidao)

@section('content')
    <div class="data-local">Câmara Municipal da Praia, {{ $dataEmissao }}</div>

    <div class="assunto">Assunto: Encerramento de Cartão Ambulante nº{{ $dados->nrCertidao }}</div>

    <p>
        Para os devidos efeitos, declara que o Cartão Ambulante registado sob o
        <strong>nº{{ $dados->nrCartao }}</strong>, em nome de {!! $dados->titularesTexto() !!},
        passou a fazer parte do nosso sistema inativo a partir do dia
        {{ $dados->dataRegistoFormatada() }}.@preencher
    </p>

    <p>
        Por ser verdade, passa a presente declaração que vai devidamente assinada e autenticada com
        carimbo a óleo em uso nesta Instituição.@preencher
    </p>
@endsection
