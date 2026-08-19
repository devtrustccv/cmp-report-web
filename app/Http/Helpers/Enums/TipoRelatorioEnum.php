<?php

namespace App\Http\Helpers\Enums;

enum TipoRelatorioEnum: string
{
    case IUPDOACAO   = 'IUPDOACAO';
    case IUPCOMPRA   = 'COMPRA-VENDA';
    case IUPPARTILHA = 'IUPPARTILHA';
    case IUPSUCESSORIO  = 'IUPSUCESSORIO';
    case IUPTERRENO  = 'IUPTERRENO';
    case IUPREMFORO  = 'IUPREMFORO';
    case CERTIDAO_MATRICIAL  = 'CERTIDAO_MATRICIAL';

    public function view(): string
    {
        return strtolower($this->value);
    }

    public function code(): string
    {
        return $this->name;
    }

    public function fileName(): string
    {
        return $this->view() . '.pdf';
    }
}