<?php

namespace App\Enums;

enum TipoAtestadoEnum: string
{
    case AGREGADO_FAMILIAR = 'ATESTADO DE AGREGADO FAMILIAR';
    case RESIDENCIA = 'ATESTADO DE RESIDÊNCIA';
    case POBREZA = 'ATESTADO DE POBREZA';

    public function view(): string
    {
        return match ($this) {
            self::AGREGADO_FAMILIAR => 'atestado.agregado_familiar',
            self::RESIDENCIA => 'atestado.residencia',
            self::POBREZA => 'atestado.pobreza',
        };
    }

    public function fileName(): string
    {
        return match ($this) {
            self::AGREGADO_FAMILIAR => 'agregado_familiar.pdf',
            self::RESIDENCIA => 'residencia.pdf',
            self::POBREZA => 'pobreza.pdf',
        };
    }
}