@extends('layout')

@section('content')

@include('components.watermark', ['estado' => $dados->estado ?? "REQ_PAG"])

<table width="100%" cellspacing="0" cellpadding="0"
       style="margin-top:10px; border:1px solid #000;">
    <tr>
        <td style="padding:6px;">
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                <tr>
                    <td style="width:64%; padding:3px 3px;"><strong>TOTAL {{$dados->tipoDuc ?? 'IUP'}} PAGO:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->total_pago ?? 0) }} </span> </td>
                    <td style="width:32%; padding:3px 3px;"><strong>Area:</strong> <span style="text-decoration: underline;">{{$dados->superficie}}</span>m2</td>
                </tr>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                <tr>
                    <td style="width:33%; padding:3px 3px;"><strong>Valor Avaliado:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->valorTransaccao ?? 0) }} </span> </td>
                    <td style="width:33%; padding:3px 3px;"><strong>V.Matricial:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->valorInicial ?? 0) }} </span> </td>
                    <td style="width:33%; padding:3px 3px;"><strong>B.Incidência:</strong> <span style="text-decoration: underline;">0</span> </td>
                </tr>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                <tr>
                    <td style="width:100%; padding:3px 3px;"><strong>Beneficiário:</strong> <span style="text-decoration: underline;">{{$dados->novosProprietarios ?? '' }} </span> </td>
                </tr>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                <tr>
                    <td style="width:100%; padding:3px 3px;"><strong>Doador:</strong> <span style="text-decoration: underline;">{{$dados->antigosProprietarios ?? '' }} </span> </td>
                </tr>
            </table>
            <h4>Confrontação:</h4>
            <table width="100%" cellspacing="0" cellpadding="0"
                style="margin-top:1px; border:1px solid #000;">
                <tr>
                    <td style="padding:6px;">
                        <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:3px;">
                            <tr>
                                <td style="width:50%; padding:3px 3px;"><strong>Norte:</strong> <span style="text-decoration: underline;">{{$dados->norte ?? ''}} </span> </td>
                                <td style="width:50%; padding:3px 3px;"><strong>Este:</strong> <span style="text-decoration: underline;">{{$dados->oeste ?? '' }} </span> </td>
                            </tr>
                            <tr>
                                <td style="width:50%; padding:3px 3px;"><strong>Sul:</strong> <span style="text-decoration: underline;">{{$dados->sul ?? '' }} </span> </td>
                                <td style="width:50%; padding:3px 3px;"><strong>Oeste:</strong> <span style="text-decoration: underline;">{{$dados->este ?? '' }} </span> </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<h4>Descrição:</h4>
<p style="
    border:1px solid #000;
    min-height:40px;
    padding:8px;
    margin-top:12px;
    margin-12px;
    margin-bottom:80px; 
    text-align: justify;
    font-size: 10px;
    word-wrap: break-word;
    overflow-wrap: break-word;
">
        {{$dados -> descMatriz ?? 'SEM DADOS' }} 
</p>
            
       

@endsection