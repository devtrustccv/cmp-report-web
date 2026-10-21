<table width="100%" cellspacing="0" cellpadding="0"
style="margin-top:50px;">
    <tr>
        <!-- COLUNA ESQUERDA -->
        @if(!empty($tipo) && in_array($tipo, ['IUPCOMPRA', 'IUPDACAO']))
           <td style="width:15%; font-size:7px;">Modelo nº 3 (Artigo 74)</td>
        
        @elseif($tipo === 'IUPDOACAO')
            <td style="width:15%;">
                <span style="display:block; font-size:7px;">Modelo nº 4 (Artigo 79)</span>
                <span style="display:block; font-size:10px; text-decoration: underline;">
                    <strong>
                         {{$dados->infoPrestacoes ?? ''}}
                    </strong>
                </span>
            </td>
         @elseif($tipo === 'IUPPARTILHA')
            <td style="width:15%; font-size:7px;">
                <span style="display:block; font-size:7px;">Modelo nº 4 (Artigo 79)</span>
                <span style="display:block; font-size:10px; text-decoration: underline;">
                    <strong>
                        {{$dados->infoPrestacoes  ?? ''}}
                    </strong>
                </span>
            </td>
        @elseif($tipo === 'IUPSUCESSORIO')
            <td style="width:15%; font-size:7px;">
                <span style="display:block; font-size:7px;">Modelo nº 3 (Artigo 74)</span>
            </td>
        @elseif($tipo === 'IUPPERMUTA')
            <td style="width:15%; font-size:7px;">
                <span style="display:block; font-size:7px;">Modelo nº 3 (Artigo 74)</span>
            </td>
        @else
           <td style="width:15%; font-size:7px;"></td>
        @endif
        <!-- COLUNA CENTRAL -->
        <td style="width:70%; text-align:center;">
            <img src="{{ public_path('images/logo.png') }}"
                 style="width:30px; height:30px; display:block; margin:0 auto 5px auto;">
            <div>República de Cabo Verde</div>
            <div style="font-size: 14px;"><strong>Câmara Municipal da Praia</strong></div>
            @if(empty($titulo) && $tipo === 'IUPPERMUTA' && ($dados->tipoDuc ?? '') === 'IUP')
                <div>IMPOSTO ÚNICO SOBRE O PATRIMÓNIO (IUP)</div>
            @else
                <div>{{$titulo ?? 'IMPOSTO SOBRE A TRANSMISSÃO DE IMÓVEIS (ITI)'}} </div>
            @endif
            
            @php
                $referente = match ($tipo ?? null) {
                    'IUPCOMPRA'     => 'Compra',
                    'IUPDACAO'      => 'Dação em Cumprimento',
                    'IUPREMFORO'    => 'Remição de FORO',
                    'IUPDOACAO'     => 'Doação',
                    'IUPPARTILHA'   => 'Partilha',
                    'IUPSUCESSORIO' => 'Sucessão',
                    'IUPTERRENO'    => $dados->regimeDesc ?? '',
                    'IUPPERMUTA'    => 'Permuta',
                    default         => null,
                };
            @endphp

            {{-- Mesma lógica da compra e venda: "Referente a ... - Proc. Nº" --}}
            @if(!is_null($referente))
                <div style="font-size: 10px;  text-decoration: underline;">Referente a {{ $referente }} - Proc. Nº {{$dados->numero_processo ?? ''}}</div>
            @endif
        </td>

        <!-- COLUNA DIREITA -->
        <td style="width:25%; text-align:rigth;">
            <div><strong>Nº DUC: </strong><span style="text-decoration: underline; ">{{$dados->duc ?? ''}}</span></div>
            @if(!empty($tipo) && $tipo !== 'IUPPERMUTA')
                <div><strong>Nº Matriz: </strong><span style="text-decoration: underline; ">{{$dados->matriz ?? ''}}</span></div>
            @endif
            {{-- Local em todos os relatórios (a permuta mostra o local de cada imóvel no corpo) --}}
            @if(!empty($tipo) && $tipo !== 'IUPPERMUTA')
                <div><strong>Local: </strong><span style="text-decoration: underline; ">{{$dados->local ?? $dados->localizacao ?? ''}}</span></div>
            @endif
        </td>
    </tr>
</table>

