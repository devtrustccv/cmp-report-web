@extends('licenciamento-comercial.layout')

{{-- LICO_CA - Cessação de Atividade --}}
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

@section('title', 'Cessação de Atividade nº ' . $dados->nrCertidao)

@section('content')

    <div class="titulo-documento">Cessação de Atividade nº{{ $dados->nrCertidao }}</div>
    <p>
        @iguais Para os devidos efeitos, declara que o Alvará Comercial registado sob o
        <strong>Nº {{ $dados->nAlvara }}</strong>, em nome do Estabelecimento,
        {!! $dados->titularesTexto() !!},
        passou a fazer parte do nosso sistema inativo a partir do dia {{ $dados->dataRegistoFormatada() }}.@preencher
    </p>

    <p>
        Por ser verdade, passa a presente declaração que vai devidamente assinada e autenticada com
        carimbo a óleo em uso nesta Instituição.@preencher
    </p>

    <p class="italico">Praia, <span class="data-emissao">{{ $dataEmissao }}.</span></p>
@endsection
