@php
    $isCertificado = ($estado ?? null) === 'FIM';
    
    function watermark($texto, $cor = 'red', $top = '40%', $fontSize = '50px', $left = '25%', $width = '50%', $opacity = '0.10') {
        return '
            <div style="
                position: fixed;
                top: '.$top.';
                left: '.$left.';
                width: '.$width.';
                text-align: center;
                opacity: '.$opacity.';
                font-size: '.$fontSize.';
                color: '.$cor.';
                transform: rotate(-45deg);
                z-index: 9999;
                white-space: nowrap;
                font-weight: bold;
            ">
                '.$texto.'
            </div>
        ';
    }

@endphp


@if($isVerificacao === 2)

    {!! watermark(
        'VÁLIDO',
        'green',
        $isCertificado ? '40%' : '20%',
        '60px',
        '25%',
        '50%',
        '0.50'
    ) !!}

    @unless($isCertificado)
        {!! watermark(
            'IMPRESSÃO NÃO CERTIFICADA',
            'red',
            '50%',
            '40px',
            '15%',
            '70%',
            '0.10'
        ) !!}
    @endunless

@elseif($isVerificacao === 3)

    {!! watermark(
        'INVÁLIDO',
        'red',
        '35%',
        '60px',
        '25%',
        '50%',
        '0.35'
    ) !!}

@elseif(!$isCertificado)

    {!! watermark('IMPRESSÃO NÃO CERTIFICADA') !!}

@endif