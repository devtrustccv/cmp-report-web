@extends('licenciamento-comercial.layout')

{{-- LICO_CA - Cessação de Atividade --}}
@php
    // ---- Parâmetros de formatação ----
    $fonte        = 'arial';
    $tamanhoFonte = '18px';
    $alturaLinha  = 1.6;

    /** @var \App\Models\CertidaoLicenciamentoDto $dados */
    $dataEmissao = \App\Models\CertidaoLicenciamentoDto::dataEmissaoExtenso();
@endphp

@section('title', 'Cessação de Atividade nº ' . $dados->nrCertidao)

@section('content')
    <div class="data-local">Câmara Municipal da Praia, {{ $dataEmissao }}</div>

    <div class="assunto">Assunto: Cessação de Atividade nº{{ $dados->nrCertidao }}</div>

    <p>
        Para os devidos efeitos, declara que o Alvará Comercial registado sob o
        <strong>nº{{ $dados->nAlvara }}</strong>, em nome do Estabelecimento,
        {!! $dados->titularesTexto() !!},
        passou a fazer parte do nosso sistema inativo a partir do dia {{ $dados->dataRegistoFormatada() }}.@preencher
    </p>

    <p>
        Por ser verdade, passa a presente declaração que vai devidamente assinada e autenticada com
        carimbo a óleo em uso nesta Instituição.@preencher
    </p>
@endsection
