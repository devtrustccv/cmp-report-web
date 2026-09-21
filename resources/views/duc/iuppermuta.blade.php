@extends('duc.layout')

@section('content')

@include('components.watermark', ['estado' => $dados->estado ?? "REQ_PAG"])

<table width="100%" cellspacing="0" cellpadding="0"
       style="margin-top:4px; border:1px solid #000;">
    <tr>
        <td style="padding:3px 6px;">
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:1px;">
                <tr>
                    <td style="width:25%; padding:1px 3px;"><strong>{{$dados->tipoDuc ?? 'IUP'}}:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->total_pago ?? 0) }}</span> </td>
                    <td style="width:25%; padding:1px 3px;"><strong>Multa:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->multa ?? 0) }}</span> </td>
                    <td style="width:25%; padding:1px 3px;"><strong>Juro:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->juro ?? 0) }}</span> </td>
                </tr>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:1px;">
                <tr>
                   <td style="width:100%; padding:1px 3px;"><strong>Total Pago:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->total_pago ?? 0) }}</span><span> {{ $dados->totalExtenso ?? ''}}</span> </td>
                </tr>
            </table>
            <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:4px; border:1px solid #000;">
                <tr>
                    <td width="50%" valign="top" style="padding:3px 6px; border-right:1px solid #000;">
                        <table width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="padding:1px 3px;"><strong>Permutante:</strong> <span style="text-decoration: underline;">{{$dados->permutante1 ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td style="padding:1px 3px;"><strong>Matriz:</strong> <span style="text-decoration: underline;">{{$dados->matriz1 ?? '' }}</span></td>
                            </tr>
                             <tr>
                                <td style="padding:1px 3px;"><strong>Valor Matriz:</strong> <span style="text-decoration: underline;">{{$dados->matriz2 ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td style="padding:1px 3px;"><strong>Área:</strong> <span style="text-decoration: underline;">{{$dados->superficie1 ?? '' }}</span>m2</td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" valign="top" style="padding:3px 6px;">
                        <table width="100%" cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="padding:1px 3px;"><strong>Permutante:</strong> <span style="text-decoration: underline;">{{$dados->permutante2 ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td style="padding:1px 3px;"><strong>Matriz:</strong> <span style="text-decoration: underline;">{{$dados->matriz2 ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td style="padding:1px 3px;"><strong>Valor Matriz:</strong> <span style="text-decoration: underline;">{{$dados->matriz2 ?? '' }}</span></td>
                            </tr>
                            <tr>
                                <td style="padding:1px 3px;"><strong>Área:</strong> <span style="text-decoration: underline;">{{$dados->superficie2 ?? '' }}</span>m2</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            @if(!empty($dados->torna))
                <table width="100%" cellspacing="0" cellpadding="0" style="margin-top:4px;">
                    <tr>
                        <td style="width:33%; padding:1px 3px;"><strong>B.Incidência:</strong> <span style="text-decoration: underline;">{{\App\Http\Utils::formatarComSeparador($dados->baseIncidencia ?? 0) }} </span> </td>
                        <td style="width:50%; padding:1px 3px;"><strong>A cargo de:</strong> <span style="text-decoration: underline;">{{ $dados->tornaBeneficiario ?? '' }}</span></td>
                    </tr>
                </table>
            @endif
        </td>
    </tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" style="page-break-inside: avoid; margin-bottom:80px;">
    <tr>
        <td width="50%" valign="top" style="padding-right:6px;">
            <h4 style="margin:4px 0 0 0;">Descrição do Imóvel ({{$dados->matriz1 ?? ''}}-{{$dados->fraccao1 ?? ''}}):</h4>
            <p style="
                border:1px solid #000;
                min-height:30px;
                padding:5px;
                margin-top: 2px;
                text-align: justify;
                font-size: 10px;
                word-wrap: break-word;
                overflow-wrap: break-word;
            ">
                {{$dados->descMatriz1 ?? '' }}
            </p>
        </td>
        <td width="50%" valign="top" style="padding-left:6px;">
            <h4 style="margin:4px 0 0 0;">Descrição do Imóvel ({{$dados->matriz2 ?? ''}}-{{$dados->fraccao2 ?? ''}}):</h4>
            <p style="
                border:1px solid #000;
                min-height:30px;
                padding:5px;
                margin-top: 2px;
                text-align: justify;
                font-size: 10px;
                word-wrap: break-word;
                overflow-wrap: break-word;
            ">
                {{$dados->descMatriz2 ?? '' }}
            </p>
        </td>
    </tr>
</table>

@endsection
