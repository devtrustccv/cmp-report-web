{{--
    Linha "=========== texto ===========" que ocupa a largura toda, com o texto ao centro.
    Uso: <x-linha-preenchida><span class="italico">Válido para fins convenientes</span></x-linha-preenchida>
    Requer as classes .linha-preenchida / .preencher definidas no layout.
--}}
<table class="linha-preenchida">
    <tr>
        <td class="lp-lado">@preencher</td>
        <td class="lp-texto">{{ $slot }}</td>
        <td class="lp-lado">@preencher</td>
    </tr>
</table>
