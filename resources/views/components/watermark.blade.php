@if(!empty($status) && $status !== 'FIM')
    <div style="
        position: fixed;
        top: 40%;
        left: 25%;
        width: 50%;
        text-align: center;
        opacity: 0.1;
        font-size: 50px;
        color: red;
        transform: rotate(-45deg);
        z-index: 9999;
        white-space: nowrap;
    ">
        IMPRESSÃO NÃO CERTIFICADA
    </div>
@endif
