@extends('declaracao.layout')

@section('title', 'Declaração de Prédios Registados')

@section('content')
    @php
        $predios = $dados?->predios ?? [];
        $totalPredios = count($predios);

        $numerosExtenso = [
            1 => 'um', 2 => 'dois', 3 => 'três', 4 => 'quatro', 5 => 'cinco',
            6 => 'seis', 7 => 'sete', 8 => 'oito', 9 => 'nove', 10 => 'dez',
        ];
        $qtdExtenso = $numerosExtenso[$totalPredios] ?? (string) $totalPredios;

        $itens = [];
        foreach ($predios as $predio) {
            $itens[] = trim(
                ($predio->tipoPredio ?? '') . ' designado por Subzona ' . ($predio->subzona ?? '') .
                '- Quarteirão ' . ($predio->quarteirao ?? '') . '- Lote ' . ($predio->lote ?? '') .
                ', com área de ' . ($predio->area ?? '') . ' m², inscrito na matriz nº ' . ($predio->numMatriz ?? '') .
                (($predio->fraccao ?? '') !== '' ? '/' . $predio->fraccao : '')
            );
        }

        $juntarComE = function (array $itens) {
            if (empty($itens)) {
                return '';
            }
            if (count($itens) === 1) {
                return $itens[0];
            }
            $ultimo = array_pop($itens);
            return implode(', ', $itens) . ' e ' . $ultimo;
        };

        $itensTexto = $juntarComE($itens);
    @endphp

    <p>
        Pelo presente se declara que em cumprimento do despacho no mesmo exarado, que compulsando o cadastro dos
        contribuintes existentes neste serviço, foi encontrado {{ $qtdExtenso }}
        {{ $totalPredios > 1 ? 'prédios urbanos localizados' : 'prédio urbano localizado' }}
        em {{ $dados?->localizacao ?? '' }}, Cidade da Praia, {{ $itensTexto }},
        {{ $totalPredios > 1 ? 'registados' : 'registado' }} a favor de
        <strong>{{ $dados?->titular ?? '' }}</strong>.
    </p>

    <p style="margin-top:30px;">
        Câmara Municipal da Praia, {{ !empty($dados?->dataEmissao) ? \Carbon\Carbon::parse($dados->dataEmissao)->translatedFormat('d \d\e F \d\e Y') : '' }}.
    </p>
@endsection
