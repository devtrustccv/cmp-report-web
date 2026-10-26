@extends('expedientes_interveniente.layout')

@section('title', 'Lista de Expedientes')

@php
    // Larguras partilhadas entre o cabeçalho (no <header> fixo) e as tabelas de cada data
    $colunas = [
        ['Data', '10%', ''],
        ['Interveniente Actual', '26%', ''],
        ['Assunto', '12%', ''],
        ['Nº', '9%', ''],
        ['Identificação', '22%', ''],
        ['Bairro', '13%', ''],
        ['Nº Dias', '8%', 'text-center'],
    ];
@endphp

@section('cabecalho_colunas')
    <table class="lista cabecalho">
        <tr>
            @foreach($colunas as [$titulo, $largura, $classe])
                <th class="{{ $classe }}" style="width:{{ $largura }};">{{ $titulo }}</th>
            @endforeach
        </tr>
    </table>
@endsection

@section('content')
    <style>
        /* Espaço extra no topo para o cabeçalho de colunas, que fica no <header> fixo */
        @page {
            margin-top: 155px;
        }

        header {
            top: -143px;
            height: 150px;
        }

        table.lista {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        table.lista th {
            border-bottom: 2px solid #000;
            text-align: left;
            font-size: 11px;
            padding: 4px 3px;
        }

        table.lista.cabecalho {
            margin-top: 8px;
        }

        table.lista td {
            padding: 3px;
            font-size: 10px;
            vertical-align: top;
            word-wrap: break-word;
        }

        table.lista.grupo-data {
            border-top: 1px solid #000;
        }

        table.lista .data,
        table.lista .interveniente,
        table.lista .assunto {
            font-weight: bold;
        }

        table.lista .nowrap {
            white-space: nowrap;
        }

        table.lista .text-center {
            text-align: center;
        }
    </style>

    {{--
        Uma tabela por data (em vez de uma única tabela com todas as linhas):
        o dompdf monta um mapa de células por tabela e, com milhares de linhas
        numa só tabela, esgota a memória.
        Agrupado por Data > Interveniente > Assunto; cada um aparece só na 1ª linha do seu grupo.
    --}}
    @forelse($grupos as $data => $itensData)
        @php
            // Achata Data > Interveniente > Assunto em linhas já com os textos de grupo resolvidos
            $linhas = [];
            $primeiraLinhaData = true;
            foreach ($itensData->groupBy('nmInterveniente') as $interveniente => $itensInterv) {
                $primeiraLinhaInterv = true;
                foreach ($itensInterv->groupBy('dsTpPedido') as $assunto => $itens) {
                    foreach ($itens->values() as $i => $item) {
                        $linhas[] = [
                            'data' => $primeiraLinhaData ? $data : '',
                            'interveniente' => $primeiraLinhaInterv ? $interveniente : '',
                            'assunto' => $i === 0 ? $assunto : '',
                            'item' => $item,
                        ];
                        $primeiraLinhaData = $primeiraLinhaInterv = false;
                    }
                }
            }
        @endphp

        {{-- Blocos de 40 linhas: tabelas pequenas mantêm o consumo de memória do dompdf baixo --}}
        @foreach(array_chunk($linhas, 40) as $b => $bloco)
            <table class="lista {{ $b === 0 && !$loop->parent->first ? 'grupo-data' : '' }}">
                @foreach($bloco as $l => $linha)
                    {{-- dompdf ignora <colgroup>: com table-layout fixed, as larguras vêm da 1ª linha --}}
                    @php $w = fn ($k) => $l === 0 ? 'style=width:' . $colunas[$k][1] : ''; @endphp
                    <tr>
                        <td class="data nowrap" {!! $w(0) !!}>{{ $linha['data'] }}</td>
                        <td class="interveniente" {!! $w(1) !!}>{{ $linha['interveniente'] }}</td>
                        <td class="assunto" {!! $w(2) !!}>{{ $linha['assunto'] }}</td>
                        <td class="nowrap" {!! $w(3) !!}>{{ $linha['item']->nrPedido }}</td>
                        <td {!! $w(4) !!}>{{ $linha['item']->nmEntidade }}</td>
                        <td {!! $w(5) !!}>{{ $linha['item']->bairro }}</td>
                        <td class="text-center" {!! $w(6) !!}>{{ $linha['item']->nrDias }}</td>
                    </tr>
                @endforeach
            </table>
        @endforeach
    @empty
        <p style="text-align:center; padding:10px;">Sem expedientes no período seleccionado.</p>
    @endforelse
@endsection
