<?php

namespace App\Http\Helpers\Enums;

/**
 * Tipos de declaração do Licenciamento Comercial.
 * O valor de cada case é o "codigo" devolvido pela API (CertidaoLicenciamentoDTO::getCodigo).
 */
enum TipoLicenciamentoComercialEnum: string
{
    case ENCERRAMENTO_CARTAO  = 'LICO_ECVA';
    case DECLARACAO_CARTAO    = 'LICO_DC';
    case DECLARACAO_ALVARA    = 'LICO_DA';
    case DIVIDA_PRESTACAO     = 'LICO_DP';
    case CESSACAO_ATIVIDADE   = 'LICO_CA';      // Alvará Comercial
    case CESSACAO_VENDA_AMBULANTE = 'LICO_CA_VEND'; // Cartão de Venda Ambulante

    public static function fromCodigo(?string $codigo): ?self
    {
        return $codigo ? self::tryFrom(strtoupper(trim($codigo))) : null;
    }

    public function view(): string
    {
        return 'licenciamento-comercial.' . match ($this) {
            self::ENCERRAMENTO_CARTAO => 'encerramento_cartao',
            self::DECLARACAO_CARTAO   => 'cartao_ambulante',
            self::DECLARACAO_ALVARA   => 'alvara_comercial',
            self::DIVIDA_PRESTACAO    => 'pagamento_prestacoes',
            self::CESSACAO_ATIVIDADE  => 'cessacao_atividade',
            self::CESSACAO_VENDA_AMBULANTE => 'cessacao_venda_ambulante',
        };
    }

    public function fileName(): string
    {
        return 'licenciamento_comercial_' . strtolower($this->value);
    }
}
