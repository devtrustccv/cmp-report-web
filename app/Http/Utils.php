<?php

namespace App\Http;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QRGdImagePNG;

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

    // método para o "Clean PDF"
    public function cleanPdf(string $inputPath): string
    {
        $cleanedPath = uniqid('cleaned_pdf_'. time(), true) . '.pdf';
        $inputAbsolutPath = storage_path('app/public/'.$inputPath);
        $cleanedAbsolutPath = storage_path('app/public/' . $cleanedPath);

        $gs = $this->resolveGhostscriptBinary();

        $cmd = $gs . " -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -sOutputFile=" . escapeshellarg($cleanedAbsolutPath) . " " . escapeshellarg($inputAbsolutPath);
        exec($cmd, $output, $return_var);

        if ($return_var !== 0) {
            throw new \Exception('Ghostscript falhou ao limpar o PDF. Certifica-te que está instalado.');
        }

        return $cleanedPath;
    }

    private function resolveGhostscriptBinary(): string
    {
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
        $candidates = $isWindows ? ['gswin64c', 'gswin32c'] : ['gs'];

        foreach ($candidates as $candidate) {
            $checkCmd = $isWindows ? "where {$candidate}" : "command -v {$candidate}";
            exec($checkCmd, $output, $code);

            if ($code === 0) {
                return $candidate;
            }
        }

        return $candidates[0];
    }

    public function generateQrCode($qrData = 'https://www.seulink.com', $qrFile = 'qrcode.png')
    {
        // Gerar o QR code
        $options = new QROptions([
            'outputInterface' => QRGdImagePNG::class,
            'eccLevel' => EccLevel::L, // Nível de correção de erro
            'outputBase64' => false,
        ]);

        // Gerar a imagem PNG do QR Code
        $qrcode = (new QRCode($options))->render($qrData);
    
        file_put_contents($qrFile, $qrcode);
    
        return $qrFile;
    }

    public function generateQrCodeBase64(string $qrData): string
    {
        $options = new QROptions([
            'outputInterface' => QRGdImagePNG::class,
            'eccLevel' => EccLevel::L,
            'outputBase64' => true, // 🔥 importante
        ]);

        return (new QRCode($options))->render($qrData);
    }

}