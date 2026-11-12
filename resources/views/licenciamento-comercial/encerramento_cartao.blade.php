@extends('licenciamento-comercial.layout')

{{-- LICO_ECVA - Encerramento de Cartão Venda Ambulante (modelo Certidão) --}}
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

@section('title', 'Certidão Nº ' . $dados->nrCertidao)

@section('content')
    <div class="titulo-documento">CERTIDÃO Nº {{ $dados->nrCertidao }}</div>

    <p>
        @iguais Certifico, de harmonia com o requerimento de {!! $dados->titularesTexto() !!},
        e em cumprimento do despacho no mesmo exarado que, compulsando o cadastro comercial existente
        neste serviço,  <span  class="italico">não se encontra registado nenhum Alvará/licença comercial</span>,
        <span style="font-style: normal;" >licenciado em nome da mesma.</span>@preencher
    </p>

    <p>
        Por ser verdade, mandei passar a presente certidão, que dato e assino e faço autenticar com
        carimbo a óleo em uso neste serviço. @preencher
    </p>

    <div class="espaco"></div>

    @if($dados->finsTexto())
        <p class="italico negrito">Válido para {{ $dados->finsTexto() }}@preencher</p>
    @endif

    @if($dados->validadeTexto())
        <p class="italico negrito">Valida por um período de {{ $dados->validadeTexto() }} meses.@preencher</p>
    @endif

    <div class="espaco"></div>

    <p class="italico">Praia, <span class="data-emissao">{{ $dataEmissao }}.</span></p>
@endsection
