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

    /**
     * Converte um valor em escudos para texto por extenso.
     * Ex: 482 => "Quatrocentos e oitenta e dois escudos"
     */
    public static function valorPorExtenso(float $valor): string
    {
        $inteiro = (int) round($valor);

        $moeda = $inteiro === 1 ? 'escudo' : 'escudos';

        // "um milhão de escudos", "dois milhões de escudos"
        if ($inteiro >= 1000000 && $inteiro % 1000000 === 0) {
            $moeda = 'de ' . $moeda;
        }

        $texto = self::inteiroPorExtenso($inteiro);

        return mb_strtoupper(mb_substr($texto, 0, 1)) . mb_substr($texto, 1) . ' ' . $moeda;
    }

    private static function inteiroPorExtenso(int $n): string
    {
        if ($n === 0) {
            return 'zero';
        }

        $milhoes = intdiv($n, 1000000);
        $milhares = intdiv($n % 1000000, 1000);
        $resto = $n % 1000;

        $grupos = [];

        if ($milhoes) {
            $grupos[] = [$milhoes * 1000000, $milhoes === 1 ? 'um milhão' : self::inteiroPorExtenso($milhoes) . ' milhões'];
        }

        if ($milhares) {
            $grupos[] = [$milhares * 1000, $milhares === 1 ? 'mil' : self::ate999PorExtenso($milhares) . ' mil'];
        }

        if ($resto) {
            $grupos[] = [$resto, self::ate999PorExtenso($resto)];
        }

        $texto = '';

        foreach ($grupos as $i => [$valorGrupo, $textoGrupo]) {
            if ($i === 0) {
                $texto = $textoGrupo;
                continue;
            }

            // Usa "e" antes do último grupo quando é < 100 ou uma centena redonda (ex: "mil e quinhentos")
            $ultimo = $i === count($grupos) - 1;
            $semMilhar = $valorGrupo < 1000 ? $valorGrupo : intdiv($valorGrupo, 1000);
            $usaE = $ultimo && ($semMilhar < 100 || $semMilhar % 100 === 0);

            $texto .= ($usaE ? ' e ' : ' ') . $textoGrupo;
        }

        return $texto;
    }

    private static function ate999PorExtenso(int $n): string
    {
        $unidades = ['', 'um', 'dois', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove',
            'dez', 'onze', 'doze', 'treze', 'catorze', 'quinze', 'dezasseis', 'dezassete', 'dezoito', 'dezanove'];
        $dezenas = ['', '', 'vinte', 'trinta', 'quarenta', 'cinquenta', 'sessenta', 'setenta', 'oitenta', 'noventa'];
        $centenas = ['', 'cento', 'duzentos', 'trezentos', 'quatrocentos', 'quinhentos',
            'seiscentos', 'setecentos', 'oitocentos', 'novecentos'];

        if ($n === 100) {
            return 'cem';
        }

        $partes = [];
        $c = intdiv($n, 100);
        $r = $n % 100;

        if ($c) {
            $partes[] = $centenas[$c];
        }

        if ($r) {
            if ($r < 20) {
                $partes[] = $unidades[$r];
            } else {
                $u = $r % 10;
                $partes[] = $dezenas[intdiv($r, 10)] . ($u ? ' e ' . $unidades[$u] : '');
            }
        }

        return implode(' e ', $partes);
    }

    // método para o "Clean PDF"
    public function cleanPdf(string $inputPath): string
    {
        $cleanedPath = uniqid('cleaned_pdf_'. time(), true) . '.pdf';
        $inputAbsolutPath = storage_path('app/public/'.$inputPath);
        $cleanedAbsolutPath = storage_path('app/public/' . $cleanedPath);

        $gs = $this->resolveGhostscriptBinary();

        $cmd = $gs . " -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -sOutputFile=" . escapeshellarg($cleanedAbsolutPath) . " " . escapeshellarg($inputAbsolutPath) . " 2>&1";
        exec($cmd, $output, $return_var);

        if ($return_var !== 0) {
            \Illuminate\Support\Facades\Log::error('Ghostscript falhou ao limpar o PDF', [
                'binario' => $gs,
                'comando' => $cmd,
                'return_var' => $return_var,
                'output' => implode("\n", $output),
            ]);
            throw new \Exception('Ghostscript falhou ao limpar o PDF (' . $gs . '): ' . implode(' | ', $output));
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