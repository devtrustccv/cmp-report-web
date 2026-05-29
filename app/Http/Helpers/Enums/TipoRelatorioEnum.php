<?php

namespace App\Http\Helpers\Enums;

enum TipoRelatorioEnum: string
{
    case IUPDOACAO   = 'IUPDOACAO';
    case IUPCOMPRA   = 'COMPRA-VENDA';
    case IUPPARTILHA = 'IUPPARTILHA';
    case IUPHERANCA  = 'IUPHERANCA';
    case IUPTERRENO  = 'IUPTERRENO';
    case IUPREMFORO  = 'IUPREMFORO';
    case CERTIDAO_MATRICIAL  = 'CERTIDAO_MATRICIAL';

    public function view(): string
    {
        return strtolower($this->value);
    }

    public function fileName(): string
    {
        return $this->view() . '.pdf';
    }
}