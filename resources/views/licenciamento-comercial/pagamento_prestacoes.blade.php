@extends('licenciamento-comercial.layout')

{{-- LICO_DP - Dívida de Prestação --}}
@php
    // ---- Parâmetros de formatação ----
    $fonte        = 'arial';
    $tamanhoFonte = '18px';
    $alturaLinha  = 1.6;
    $dataEmissao = \App\Models\CertidaoLicenciamentoDto::dataEmissaoExtenso();
    /** @var \App\Models\CertidaoLicenciamentoDto $dados */
@endphp

@section('title', 'Declaração Nº ' . $dados->nrCertidao)

@section('content')
    <div class="titulo-documento" style="text-decoration: none;">DECLARAÇÃO Nº{{ $dados->nrCertidao }}</div>

    <p>
        @iguais(5) Para os devidos efeitos, declara que o Alvará registado sob o <strong>nº {{ $dados->nAlvara }}</strong>,
        em nome do estabelecimento, {!! $dados->titularesTexto() !!},
        encontra-se a pagar as suas dívidas em prestações{{ $dados->nrPrestacao ? ' (prestação nº ' . $dados->nrPrestacao . ')' : '' }},
        referente as taxas de licenciamento comercial.@preencher
    </p>

    @if($dados->validadeTexto())
        <p>
            @iguais(5) Neste sentido, a referida empresa fica autorizada a exercer a sua atividade económica, por um
            período de {{ $dados->validadeTexto() }} meses, a contar da data da emissão da presente declaração.@preencher
        </p>
    @endif

    <p>
        @iguais(5) Por ser verdade, passa a presente declaração que vai devidamente assinada e autenticada com
        carimbo a óleo em uso nesta Instituição.@preencher
    </p>

    <p class="italico">CMP, {{ $dataEmissao }}.</p>
@endsection
