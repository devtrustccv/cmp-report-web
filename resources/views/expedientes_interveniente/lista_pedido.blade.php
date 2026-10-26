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
        table.lista .assunto {
            font-weight: bold;
        }

        table.lista .text-center {
            text-align: center;
        }
    </style>

    <table class="lista">
        <thead>
            <tr>
                <th style="width:11%;">Data</th>
                <th style="width:19%;">Assunto</th>
                <th style="width:12%;">Nº</th>
                <th style="width:30%;">Identificação</th>
                <th style="width:18%;">Bairro</th>
                <th style="width:10%;" class="text-center">Nº Dias</th>
            </tr>
        </thead>
        <tbody>
            @forelse($grupos as $data => $itensData)
                @php $primeiraLinhaData = true; @endphp
                @foreach($itensData->groupBy('dsTpPedido') as $assunto => $itens)
                    @foreach($itens as $i => $item)
                        <tr class="{{ $primeiraLinhaData ? 'grupo-data' : '' }}">
                            <td class="data">{{ $primeiraLinhaData ? $data : '' }}</td>
                            <td class="assunto">{{ $i === 0 ? $assunto : '' }}</td>
                            <td>{{ $item->nrPedido }}</td>
                            <td>{{ $item->nmEntidade }}</td>
                            <td>{{ $item->bairro }}</td>
                            <td class="text-center">{{ $item->nrDias }}</td>
                        </tr>
                        @php $primeiraLinhaData = false; @endphp
                    @endforeach
                @endforeach
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:10px;">Sem expedientes no período seleccionado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
