<?php

namespace App\Http\Helpers\Enums;

enum TipoDeclaracaoEnum: string
{
    case PREDIOS_REGISTADOS = 'PREDIOS_REGISTADOS';

    public function slug(): string
    {
        return match ($this) {
            self::PREDIOS_REGISTADOS => 'predios-registados',
        };
    }

    public static function fromSlug(string $slug): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->slug() === $slug) {
                return $case;
            }
        }

        return null;
    }

    public function view(): string
    {
        return match ($this) {
            self::PREDIOS_REGISTADOS => 'declaracao.predios_registados',
        };
    }

    public function titulo(): string
    {
        return match ($this) {
            self::PREDIOS_REGISTADOS => 'DECLARAÇÃO',
        };
    }

    public function fileName(): string
    {
        return match ($this) {
            self::PREDIOS_REGISTADOS => 'declaracao_predios_registados',
        };
    }
}
