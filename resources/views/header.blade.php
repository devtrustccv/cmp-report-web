<table width="100%" cellspacing="0" cellpadding="0"
style="margin-top:50px;">
    <tr>
        <!-- COLUNA ESQUERDA -->
        @if(!empty($tipo) && $tipo == 'IUPCOMPRA')
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
        @else
           <td style="width:15%; font-size:7px;"></td>
        @endif
        <!-- COLUNA CENTRAL -->
        <td style="width:70%; text-align:center;">
            <img src="{{ public_path('images/logo.png') }}"
                 style="width:30px; height:30px; display:block; margin:0 auto 5px auto;">
            <div>República de Cabo Verde</div>
            <div style="font-size: 14px;"><strong>DOCUMENTO SO PARA USO INTERNO DO MUNICIPIO</strong></div>
            <div>{{$titulo ?? 'IMPOSTO SOBRE A TRANSMISSÃO DE IMÓVEIS (ITI)'}} </div>
            
            @if(!empty($tipo) && $tipo == 'IUPCOMPRA')
                <div style="font-size: 10px;  text-decoration: underline;">Referente a Compra - Proc. Nº {{$dados->numero_processo ?? ''}}</div>
            @elseif(!empty($tipo) && $tipo == 'IUPREMFORO')
               <div style="font-size: 10px;  text-decoration: underline;">Referente a Remição de FORO</div>
            @elseif(!empty($tipo) && $tipo == 'IUPDOACAO')
              <div  style="font-size: 10px;  text-decoration: underline;">Referente a Doação</div>
            @elseif(!empty($tipo) && $tipo == 'IUPPARTILHA')
              <div  style="font-size: 10px;  text-decoration: underline;">Referente a Partilha</div>
            @endif
        </td>

        <!-- COLUNA DIREITA -->
        <td style="width:25%; text-align:rigth;">
            <div><strong>Nº DUC: </strong><span style="text-decoration: underline;">{{$dados->duc ?? ''}}</span></div>
            <div><strong>Nº Matriz: </strong><span style="text-decoration: underline;">{{$dados->matriz ?? ''}}</span></div>
            @if(!empty($tipo) && $tipo == 'IUPCOMPRA')
                <div><strong>Local: </strong><span style="text-decoration: underline;">{{$dados->local ?? ''}}</span></div>
            @elseif(!empty($tipo) && $tipo == 'IUPPARTILHA')
               <div><strong>Nº Processo: </strong><span style="text-decoration: underline;">{{$dados->numero_processo ?? ''}}</span></div>
            @elseif(!empty($tipo) && $tipo == 'IUPDOACAO')
               <div><strong>Nº Processo: </strong><span style="text-decoration: underline;">{{$dados->numero_processo ?? ''}}</span></div>
            @endif
        </td>
    </tr>
</table>

