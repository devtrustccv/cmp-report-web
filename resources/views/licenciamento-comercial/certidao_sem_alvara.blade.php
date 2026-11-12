@extends('licenciamento-comercial.layout')

@php
    // ---- Parâmetros de formatação ----
    $fonte        = 'arial';
    $tamanhoFonte = '18px';
    $alturaLinha  = 1.5;

    // ---- Dados (estáticos até ligar a API) ----
    $d = $dados ?? (object) [
        'numero'      => '006/2026',
        'tratamento'  => 'Senhora',
        'nome'        => 'Celestina Pereira',
        'documento'   => 'CNI',
        'numDocumento'=> '19810121F002H',
        'residencia'  => 'Terra Branca - Praia',
        'validadeMeses' => '3 (Três)',
    ];
@endphp

@section('title', 'Certidão Nº ' . $d->numero)

@section('content')
    <div class="titulo-documento">CERTIDÃO Nº {{ $d->numero }}</div>

    <p class="italico">
        ==========Certifico, de harmonia com o requerimento da {{ $d->tratamento }},
        <strong>{{ $d->nome }},</strong> {{ $d->documento }} – {{ $d->numDocumento }}, residente em
        {{ $d->residencia }}, e em cumprimento do despacho no mesmo exarado que, compulsando o cadastro
        comercial existente neste serviço, não se encontra registado nenhum Alvará/licença comercial,
        licenciado em nome da mesma.==============
    </p>

    <p class="italico">
        Por ser verdade, mandei passar a presente certidão, que dato e assino e faço autenticar com
        carimbo a óleo em uso neste serviço.
    </p>

    <div class="espaco"></div>

    <p class="negrito centro">
        ============= <span class="italico" style="font-weight: normal;">Válido para fins convenientes</span> =============
    </p>

    <p class="italico">Valida por um período de {{ $d->validadeMeses }} meses</p>
@endsection
