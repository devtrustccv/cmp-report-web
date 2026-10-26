@extends('expedientes_interveniente.layout')

@section('title', 'Lista de Expedientes')

@section('content')
    <style>
        table.lista {
            border-collapse: collapse;
            width: 100%;
        }

        table.lista th {
            border-bottom: 2px solid #000;
            text-align: left;
            font-size: 11px;
            padding: 4px 3px;
        }

        table.lista td {
            padding: 3px;
            font-size: 10px;
            vertical-align: top;
        }

        table.lista tr.grupo-data td {
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

    <table class="lista">
        <thead>
            <tr>
                <th style="width:10%;">Data</th>
                <th style="width:26%;">Interveniente Actual</th>
                <th style="width:12%;">Assunto</th>
                <th style="width:9%;">Nº</th>
                <th style="width:22%;">Identificação</th>
                <th style="width:13%;">Bairro</th>
                <th style="width:8%;" class="text-center">Nº Dias</th>
            </tr>
        </thead>
        <tbody>
            {{-- Agrupado por Data > Interveniente > Assunto; cada um aparece só na 1ª linha do seu grupo --}}
            @forelse($grupos as $data => $itensData)
                @php $primeiraLinhaData = true; @endphp
                @foreach($itensData->groupBy('nmInterveniente') as $interveniente => $itensInterv)
                    @php $primeiraLinhaInterv = true; @endphp
                    @foreach($itensInterv->groupBy('dsTpPedido') as $assunto => $itens)
                        @foreach($itens as $i => $item)
                            <tr class="{{ $primeiraLinhaData ? 'grupo-data' : '' }}">
                                <td class="data nowrap">{{ $primeiraLinhaData ? $data : '' }}</td>
                                <td class="interveniente">{{ $primeiraLinhaInterv ? $interveniente : '' }}</td>
                                <td class="assunto">{{ $i === 0 ? $assunto : '' }}</td>
                                <td class="nowrap">{{ $item->nrPedido }}</td>
                                <td>{{ $item->nmEntidade }}</td>
                                <td>{{ $item->bairro }}</td>
                                <td class="text-center">{{ $item->nrDias }}</td>
                            </tr>
                            @php $primeiraLinhaData = false; $primeiraLinhaInterv = false; @endphp
                        @endforeach
                    @endforeach
                @endforeach
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:10px;">Sem expedientes no período seleccionado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
