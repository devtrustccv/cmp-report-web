@extends('licenciamento-comercial.layout')

{{-- LICO_DP - Dívida de Prestação --}}
@php
    // ---- Parâmetros de formatação ----
    $fonte        = 'times'; // Times New Roman
    $tamanhoFonte = '1.2rem'; // 20px
    $alturaLinha  = 1.4;       // espaço entre as linhas de um parágrafo
    $corTexto     = '#333333';
    view()->share(compact('fonte', 'tamanhoFonte')); // o <x-linha-preenchida> mede com a mesma fonte
    $dataEmissao = \App\Models\CertidaoLicenciamentoDto::dataEmissaoExtenso();
    /** @var \App\Models\CertidaoLicenciamentoDto $dados */
@endphp

@section('title', 'Declaração Nº ' . $dados->nrCertidao)

@section('content')
    <div class="titulo-documento" style="text-decoration: none;">DECLARAÇÃO Nº{{ $dados->nrCertidao }}</div>

    <p>
        @iguais Para os devidos efeitos, declara que o Alvará registado sob o <strong>nº {{ $dados->nAlvara }}</strong>,
        em nome do estabelecimento, {!! $dados->titularesTexto() !!},
        encontra-se a pagar as suas dívidas em prestações{{ $dados->nrPrestacao ? ' (prestação nº ' . $dados->nrPrestacao . ')' : '' }},
        referente as taxas de licenciamento comercial.@preencher
    </p>

    @if($dados->validadeTexto())
        <p>
            Neste sentido, a referida empresa fica autorizada a exercer a sua atividade económica, por um
            período de {{ $dados->validadeTexto() }} meses, a contar da data da emissão da presente declaração.@preencher
        </p>
    @endif

    <p>
        Por ser verdade, passa a presente declaração que vai devidamente assinada e autenticada com
        carimbo a óleo em uso nesta Instituição.@preencher
    </p>

    <p class="italico">Praia, <span class="data-emissao">{{ $dataEmissao }}.</span></p>
@endsection
