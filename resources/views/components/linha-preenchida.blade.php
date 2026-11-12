{{--
    Linha "======= texto =======" centrada que ocupa exatamente a largura do texto, sem passar a margem.
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
    [$esquerda, $direita] = \App\Http\Helpers\LinhaPreenchida::lados((string) $slot, $fonte, $tamanho, (bool) $italico);
@endphp

<p class="linha-preenchida {{ $italico ? 'italico' : '' }}">{{ $esquerda }} {{ $slot }} {{ $direita }}</p>
