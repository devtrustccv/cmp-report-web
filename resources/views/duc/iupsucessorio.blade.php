@extends('duc.layout')

@section('content')

@include('components.watermark', ['estado' => $dados->estado ?? "REQ_PAG"])

<table width="100%" cellspacing="0" cellpadding="0"
       style="margin-top:10px; border:1px solid #000;">
    <tr>
        <td style="padding:6px;">
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                <tr>
                    <td style="width:25%; padding:3px 3px;"><strong>{{$dados->tipoDuc ?? 'IUP'}}:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->total_pago ?? 0) }}</span> </td>
                    <td style="width:25%; padding:3px 3px;"><strong>Multa:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->multa ?? 0) }}</span> </td>
                    <td style="width:25%; padding:3px 3px;"><strong>Juro:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->juro ?? 0) }}</span> </td>
                </tr>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                <tr>
                   <td style="width:100%; padding:3px 3px;"><strong>Total Pago:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->total_pago ?? 0) }}</span><span> {{ $dados->totalExtenso ?? ''}}</span> </td>
                </tr>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                <tr>
                    <td style="width:34%; padding:3px 3px;"><strong>Valor Avaliado:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->valorTransaccao ?? 0) }} </span> </td>
                    <td style="width:33%; padding:3px 3px;"><strong>V.Matricial:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->valorInicial ?? 0) }} </span> </td>
                    <td style="width:33%; padding:3px 3px;"><strong>Area:</strong> <span style="text-decoration: underline;">{{$dados->superficie ?? ''}}</span>m2</td>
                </tr>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                <tr>
                    <td style="width:100%; padding:3px 3px;"><strong>Herdeiros:</strong> <span style="text-decoration: underline;">{{$dados->novosProprietarios ?? '' }} </span> </td>
                </tr>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                <tr>
                    <td style="width:100%; padding:3px 3px;"><strong>Autor Sucessório:</strong> <span style="text-decoration: underline;">{{$dados->antigosProprietarios ?? '' }} </span> </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div style="page-break-inside: avoid;">
    <h4>Descrição:</h4>
    <p style="
        border:1px solid #000;
        min-height:40px;
        padding:8px;
        margin-top: 3px;
        margin-12px;
        margin-bottom:80px;
        text-align: justify;
        font-size: 10px;
        word-wrap: break-word;
        overflow-wrap: break-word;
    ">
            {{$dados -> descMatriz ?? 'SEM DADOS' }}
    </p>
</div>



@endsection
