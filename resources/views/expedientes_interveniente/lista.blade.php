@extends('expedientes_interveniente.layout')

@section('title', 'Lista de Expedientes Encaminhados por Interveniente')

@section('content')
    <style>
        table.lista {
            border-collapse: collapse;
            width: 100%;
        }

        table.lista th {
            border-bottom: 2px solid #000;
            text-align: left;
            font-size: 10px;
            padding: 4px 3px;
        }

        table.lista td {
            padding: 3px;
            font-size: 10px;
            vertical-align: top;
        }

        table.lista tr.grupo-data td {
            font-weight: bold;
            padding-top: 6px;
            border-top: 1px solid #000;
        }

        table.lista .text-right {
            text-align: right;
        }
    </style>

    <table class="lista">
        <thead>
            <tr>
                <th style="width:8%;">Data Fase</th>
                <th style="width:13%;">Interveniente Actual</th>
                <th style="width:13%;">Interveniente Anterior</th>
                <th style="width:12%;">Assunto</th>
                <th style="width:12%;">Fase</th>
                <th style="width:9%;">Nº</th>
                <th style="width:18%;">Identificação</th>
                <th style="width:9%;">Bairro</th>
                <th style="width:6%;">Nº Dias</th>
            </tr>
        </thead>
        <tbody>
            @forelse($grupos as $data => $itensData)
                <tr class="grupo-data">
                    <td colspan="9">{{ $data }}</td>
                </tr>
                @php $subgrupos = $itensData->groupBy('nmInterveniente'); @endphp
                @foreach($subgrupos as $interveniente => $itens)
                    @foreach($itens as $i => $item)
                        <tr>
                            <td></td>
                            <td>{{ $i === 0 ? $interveniente : '' }}</td>
                            <td>{{ $item->nmIntervAnt }}</td>
                            <td>{{ $item->dsTpPedido }}</td>
                            <td>{{ $item->dsFase }}</td>
                            <td>{{ $item->pedido }}</td>
                            <td>{{ $item->nmEntidade }}</td>
                            <td>{{ $item->bairro }}</td>
                            <td class="text-right">{{ $item->nrDias }}</td>
                        </tr>
                    @endforeach
                @endforeach
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:10px;">Sem expedientes encaminhados no período seleccionado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
