<?php

namespace App\Services;

use Exception;

class UrlCryptoService
{
    public function decrypt(string $token): array
    {
        $secret = config('services.report_crypto.secret');

        if (empty($secret)) {
            throw new Exception('Chave de desencriptação não configurada.');
        }

        $raw = $this->base64UrlDecode($token);

        if (strlen($raw) <= 16) {
            throw new Exception('Token inválido.');
        }

        $iv = substr($raw, 0, 16);
        $encrypted = substr($raw, 16);

        $key = substr($secret, 0, 32);

        $decrypted = openssl_decrypt(
            $encrypted,
            'AES-256-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($decrypted === false) {
            throw new Exception('Token inválido ou expirado.');
        }

        parse_str($decrypted, $params);

        return $params;
    }

    private function base64UrlDecode(string $token): string
    {
        $base64 = str_replace(['-', '_'], ['+', '/'], $token);

        $padding = strlen($base64) % 4;

        if ($padding > 0) {
            $base64 .= str_repeat('=', 4 - $padding);
        }

        $decoded = base64_decode($base64, true);

        if ($decoded === false) {
            throw new Exception('Token Base64 inválido.');
        }

        return $decoded;
    }


    public function encrypt(string $plainText): string
    {
        $secret = config('services.report_crypto.secret');

        if (empty($secret)) {
            throw new \Exception('Chave de encriptação não configurada.');
        }

        $key = substr($secret, 0, 32);
        $iv = random_bytes(16);

        $encrypted = openssl_encrypt(
            $plainText,
            'AES-256-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($encrypted === false) {
            throw new \Exception('Erro ao encriptar parâmetros.');
        }

        return $this->base64UrlEncode($iv . $encrypted);
    }

    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}