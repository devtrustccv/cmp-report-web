<?php

namespace App\Http;

class Utils
{
    /**
     * Limita o tamanho de uma string e adiciona "..." se ultrapassar.
     *
     * @param string $text
     * @param int $maxLength
     * @return string
     */
    public static function limitarTexto(string $text, int $maxLength): string
    {
        if (mb_strlen($text) <= $maxLength) {
            return $text;
        }

        // Substring multibyte + adicionar "..."
        return mb_substr($text, 0, $maxLength) . '...';
    }


    public static function formatarComSeparador(float $valor, string $moeda = '$'): string {
        return number_format($valor) . $moeda.'00';
    }

}