{{--
    Linha "======= texto =======" justificada: vai exatamente da margem esquerda à direita, nunca passa a margem.
    O nº de "=" é calculado com as métricas de fonte do dompdf (App\Http\Helpers\LinhaPreenchida).

    Uso:
      <x-linha-preenchida>Válido para fins convenientes</x-linha-preenchida>
      <x-linha-preenchida italico>Válido para fins convenientes</x-linha-preenchida>

    Props (devem coincidir com $fonte / $tamanhoFonte da view):
      fonte   = 'arial' | 'times' | 'courier'   (default 'arial')
      tamanho = '18px'                          (default '18px')
      italico = true/false                      (default false)
--}}
@props(['fonte' => 'arial', 'tamanho' => '18px', 'italico' => false])

@php
    $linha = \App\Http\Helpers\LinhaPreenchida::calcular((string) $slot, $fonte, $tamanho, (bool) $italico);
@endphp

@if($linha['lado'] !== '')
    {{-- cabe numa linha: "=== texto ===" de margem a margem --}}
    <p class="linha-preenchida {{ $italico ? 'italico' : '' }}" style="word-spacing: {{ $linha['wordSpacing'] }}pt;">{{ $linha['lado'] }} {{ trim($slot) }} {{ $linha['lado'] }}</p>
@else
    {{-- texto maior que a linha: parágrafo justificado + "=" a preencher o resto da última linha --}}
    <p class="{{ $italico ? 'italico' : '' }}">{{ trim($slot) }}@preencher</p>
@endif
