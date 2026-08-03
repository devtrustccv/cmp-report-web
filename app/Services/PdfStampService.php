<?php

namespace App\Services;

use App\Http\Utils;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;  // Importar Storage facade
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use setasign\Fpdi\Fpdi;
use App\Services\UtilsService;
use Illuminate\Support\Facades\Log;


class PdfStampService
{
    protected $utilsService;

    // Injeção da dependência UtilsService
    public function __construct(Utils $utilsService)
    {
        $this->utilsService = $utilsService;
    }


    public function cleanAndSignPDF($filePath, $signaturePath, $signature_url, $position, $nome_assinatura, $contraprova, $numero_processo, $link, $pelo, $competencia)
    {
        if ($this->isEncryptedPDF($filePath)) {
            Log::info("Para Ficheiros Encriptado.");
            Log::info("Caminho temporario ficheiro: $filePath");
            // Pré-processar o PDF com Ghostscript
            $cleanedPath = $this->utilsService->cleanPdf($filePath);

            // Apagar ficheiros temporários
            Storage::disk('public')->delete($filePath);

            //$filePath = public_path($filePath);
            Log::info("Caminho temporario ficheiro (absoluto): $filePath");

            $filePath = $cleanedPath;
            //return response()->json(['errors' => ['pdf' => 'O PDF está criptografado e não pode ser assinado.']], 400);
        }

        $signaturePath = $signaturePath ?? '';

        [$x, $y]= $this->getSignaturePosition($position);

        return $this->signPDF($filePath, $signaturePath, $signature_url, $x, $y, $nome_assinatura
            ,$contraprova ?? '',
            $numero_processo,
            $link, $pelo, $competencia);
    }

    /**
     * Estampa o PDF e devolve o conteúdo binário do PDF assinado.
     */
    private function signPDF(
        string $filePath,
        string $signaturePath,
        string $signature_url, $x, $y,
        string $nome_assinatura,
        string $contraprova,
        string $numero_processo,
        ?string $link = null,
        string $pelo = '',
        string $competencia = ''
    ): string {
        $data_atual = Carbon::now()->format('d-m-Y');
        $pelo = utf8_decode($pelo);
        $competencia = utf8_decode($competencia);
        $nome_assinatura = utf8_decode($nome_assinatura);
        $numero_processo = utf8_decode($numero_processo);
        $contraprova = utf8_decode($contraprova);
        try {
            // definir o limite de memória usada pelo PHP para carregar o PDF grandes.
            //ini_set('memory_limit', '1024M');
            $pdf = new \setasign\Fpdi\Fpdi();
            $fileInput = storage_path('app/public/'.$filePath);
            $pages_count = $pdf->setSourceFile($fileInput);
            
            $qrFilePath= null;
            if ($link) {
                $qrFilePath = $filePath.'.qrcode.png';
                $qrFile = $this->utilsService->generateQrCode($link,  storage_path('app/public/'.$qrFilePath));
            }

            $imgPath = $signature_url;

            if ($signaturePath) {
                $imgPath = storage_path('app/public/'.$signaturePath );
            }

        for ($i = 1; $i <= $pages_count; $i ++) {
            $templateId = $pdf->importPage($i);

            $size = $pdf->getTemplateSize($templateId);
            $width = $size['width'] ;
            $height = $size['height'];

            $orientation = ($width > $height) ? 'L' : 'P';
            $pdf->AddPage($orientation, [$width, $height]);
            $pdf->useTemplate($templateId);

            //Log::channel('stderr')->info("orientation...{$orientation}");
            //Log::channel('stderr')->info("width...{$width}");
            //Log::channel('stderr')->info("height...{$height}");
//-----
            $tplIdx = $pdf->importPage($i);
            $pdf->useTemplate($tplIdx, 0, 0);
            $pdf->SetFont('Times', '', 12);
            $pdf->SetTextColor(0, 0, 0);

            $pdf->SetFont('Arial', '', 12);
            $pdf->SetFillColor(255, 255, 255); // cor de fundo branca
            $pdf->SetDrawColor(0, 0, 0); // cor da borda preta

            // Vertical tamanho Padrão: width...210 height...297
            // Crie o retângulo
            $pdf->Rect(20, $height - 32, $width - 35, 30 , 'DF'); // x(20), y(265), largura(175), altura(30), estilo

            // Coluna 1: QRCode
            if ($link) {
                $pdf->Image($qrFile, $width - 40, $height - 30, 20, 20, 'PNG'); // x (170), y(267), largura(20), altura(20) ### new

                $pdf->Image( $imgPath , $width - 82, $height - 30, 30, 0, 'PNG'); // x (128), y(267), largura(30), altura(0 "auto") ### new
                $pdf->SetFont('Times', '', 12);
                $this->writeWrappedText($pdf, $width - 87, $height - 28, 43, $pelo); // x(123), y(269) — para antes do QR code (width - 40)
                $pdf->Text($width - 95, $height - 17, '________________________'); // x(115), y(280)
                $pdf->SetFont('Times', '', 12);
                $pdf->Text($width - 87, $height - 12, $nome_assinatura); // x(123), y(286)
                $pdf->SetFont('Times', '', 7);
                $pdf->Text($width - 87, $height - 9, $competencia);  // x(123), y(288)
            } else {
                ### $pdf->Image( $imgPath , 148, 267, 30, 0, 'PNG'); ### old
                $pdf->Image( $imgPath , $width - 62, $height - 30, 30, 0, 'PNG'); ### new
                $pdf->SetFont('Times', '', 12);
                $this->writeWrappedText($pdf, $width - 65, $height - 28, 48, $pelo);// x(145), y(269)
                $pdf->Text($width - 70, $height - 17, '________________________'); // x(140), y(280)
                $pdf->SetFont('Times', '', 12);
                $pdf->Text($width - 65, $height - 12, $nome_assinatura);// x(145), y(286)
                $pdf->SetFont('Times', '', 7);
                $pdf->Text($width - 65, $height - 9, $competencia); // x(145), y(288)
            }

            $pdf->SetFont('Times', '', 9);
            $pdf->Text($width - 65, $height - 5, 'Data de Assinatura: '.$data_atual);// x(145), y(292)
            $pdf->SetFont('Times', '', 12);
            $pdf->Text(25, $height - 27, utf8_decode('Despacho Digital CMP / Nº Processo: ').$numero_processo); // x(25), y(270)
            $pdf->SetFont('Times', 'B', 12);
            $pdf->Text(25, $height - 17, 'Contra Prova / Validation Code'); // x(25), y(280)
            $pdf->Text(25, $height - 7, $contraprova);// x(25), y(290)
        }
       
        $stampedContent = $pdf->Output('S');

        Storage::disk('public')->delete([$filePath, $signaturePath, $qrFilePath]);

        Log::channel('pdfstamper')->info("PDF assinado com sucesso.");

        return $stampedContent;

    } catch (\Exception $e) {

        Log::channel('pdfstamper')->error("Erro ao assinar PDF: " . $e->getMessage());

        throw new \Exception('Erro ao processar o PDF: ' . $e->getMessage());
    }
    }
    
    /**
     * Escreve $text quebrado em linhas dentro de $maxWidth (mm), reduzindo o tamanho
     * da fonte (de $maxSize até $minSize) até caber em até $preferredLines linhas.
     * Nunca corta o texto: se mesmo no tamanho mínimo não couber em $preferredLines,
     * desenha o texto completo usando quantas linhas forem necessárias.
     */
    private function writeWrappedText($pdf, $x, $y, $maxWidth, string $text, $font = 'Times', $style = '', $maxSize = 12, $minSize = 7, $preferredLines = 2)
    {
        $text = trim($text);
        if ($text === '') {
            return;
        }

        $lines = [];
        for ($size = $maxSize; $size >= $minSize; $size--) {
            $pdf->SetFont($font, $style, $size);
            $lines = $this->wrapTextToLines($pdf, $text, $maxWidth);
            if (count($lines) <= $preferredLines) {
                break;
            }
        }

        $lineHeight = $size / 3;
        foreach ($lines as $i => $line) {
            $pdf->Text($x, $y + ($i * $lineHeight), $line);
        }
    }

    private function wrapTextToLines($pdf, string $text, $maxWidth): array
    {
        $words = explode(' ', $text);
        $lines = [];
        $currentLine = '';

        foreach ($words as $word) {
            $testLine = $currentLine === '' ? $word : $currentLine.' '.$word;
            if ($pdf->GetStringWidth($testLine) > $maxWidth && $currentLine !== '') {
                $lines[] = $currentLine;
                $currentLine = $word;
            } else {
                $currentLine = $testLine;
            }
        }
        if ($currentLine !== '') {
            $lines[] = $currentLine;
        }

        return $lines;
    }

    public function addWatermark($x, $y, $watermarkText, $angle, $pdf) {
        $angle = $angle * M_PI / 180;
        $c = cos($angle);
        $s = sin($angle);
        $cx = $x * 1;
        $cy = (300 - $y) * 1;
        $pdf->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, - $s, $c, $cx, $cy, - $cx, - $cy));
        $pdf->Text($x, $y, $watermarkText);
        $pdf->_out('Q');
    }

    private function getSignaturePosition($position) {
        switch ($position) {
            case 'esquerda_superior':
                return [10, 8]; // x = 10, y = 10
            case 'direita_superior':
                return [170, 6]; // x = 155, y = 10
            case 'centro_superior':
                return [85, 6]; // x = 85, y = 10
            case 'esquerda_inferior':
                return [10, 255]; // x = 10, y = 275
            case 'direita_inferior':
                return [150, 275]; // x = 155, y = 275
            case 'centro_inferior':
                return [85, 275]; // x = 85, y = 275
            default:
                return [85, 275]; // Posição padrão: centro inferior
        }
    }


    public function isEncryptedPDF($filePath){
        try {
            // Usando FPDI para verificar se o PDF está criptografado
            $pdf = new \setasign\Fpdi\Fpdi();
            $fileInput = storage_path('app/public/'.$filePath);

            // Verifica se o PDF está criptografado
            return $pdf->setSourceFile($fileInput) === false; // Se setSourceFile falhar, o PDF está criptografado
        } catch (\Exception $e) {
            return true; // Se ocorrer um erro, assume-se que o PDF está criptografado
        }
    }

    public function mergePdfs(array $paths): bool {
        $pdf = new Fpdi();

        $deleteFile = $paths;

        foreach ($paths as $file) {

            $filePath = storage_path("app/public/{$file}");

            if (!file_exists($filePath)) {
                continue; // ou lançar exceção
            }

            //Validar ficheiro comprimido ou emncriptado
            if ($this->isEncryptedPDF($file)) {
                Log::channel('stderr')->info(":::::::Para Ficheiros Encriptado: $filePath");
                // Passo 1: Repara o PDF
                ### $cleanedPath = $this->repairPdf($file);
               
                // Pré-processar o PDF com Ghostscript
                $cleanedPath = $this->utilsService->cleanPdf($file);

                array_push($deleteFile, $cleanedPath); // add to delete on end procedure
                    
                $filePath = storage_path("app/public/{$cleanedPath}");
                Log::channel('stderr')->info("::::::::::::::cleanedPath: $filePath");
            }

            Log::channel('stderr')->info("::::::::::::::filePath: $filePath");
            $pageCount = $pdf->setSourceFile($filePath);

            for ($i = 1; $i <= $pageCount; $i++) {
                $templateId = $pdf->importPage($i);
                $size = $pdf->getTemplateSize($templateId);
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);
            }
        }
        ## 'I'	Inline: exibe o PDF no navegador (não força download)
        ## 'D'	Download: força o download do PDF pelo navegador
        ## 'F'	File: salva o PDF num ficheiro local (caminho passado em $name)
        ## 'S'	String: retorna o conteúdo PDF como string (sem salvar nem exibir)
        //$pdf->Output('I', $outputPath); 
        $pdf->Output('I', "merged_doc-". date('Ymd_His').'.pdf');

        // Apagar ficheiros temporários
        Storage::disk('public')->delete([...$deleteFile]);

        return true;
    }


    ///-------------------------------------
    /* *
     * Adiciona um stamp a um PDF usando PDFTK.
     * O método aceita apenas imagens no formato PDF (geralmente um arquivo de assinatura).
     *
     * @param string $pdfPath Caminho do arquivo PDF original.
     * @param string $stampPath Caminho do arquivo de assinatura (PDF).
     * @param string $outputPath Caminho onde o PDF final será salvo.
     * @return void
     * /
    public function addStampToPdf($pdfPath, $stampPath, $outputPath)
    {
        $command = "pdftk {$pdfPath} stamp {$stampPath} output {$outputPath}";

        // Executa o comando PDFTK no terminal
        exec($command);

        // Verifica se o arquivo foi criado
        if (!file_exists($outputPath)) {
            throw new \Exception("Erro ao adicionar o stamp no PDF.");
        }
    }

    / **
     * Mescla múltiplos arquivos PDF em um único PDF.
     *
     * @param array $pdfFiles Caminho dos arquivos PDF a serem mesclados.
     * @param string $outputPath Caminho onde o PDF final será salvo.
     * @return void
     * /
    public function mergePdfs($pdfFiles, $outputPath)
    {
        $filesString = implode(' ', $pdfFiles);
        $command = "pdftk {$filesString} cat output {$outputPath}";

        // Executa o comando PDFTK no terminal
        exec($command);

        // Verifica se o arquivo foi criado
        if (!file_exists($outputPath)) {
            throw new \Exception("Erro ao mesclar os arquivos PDF.");
        }
    }*/
    
    /**
     * Repara um PDF usando PDFTK.
     * Isso pode corrigir problemas de estrutura ou corrupção do PDF.
     *
     * @param string $inputPdf Caminho do arquivo PDF original.
     * @return string
     */
    public function repairPdf($inputPdf): string {

        $repairedPdf = uniqid('repair_pdf_'. time(), true) . '.pdf';

        $inputAbsolutPath = storage_path('app/public/'.$inputPdf);
        $repairedAbsolutPath = storage_path('app/public/' . $repairedPdf);

        // Comando PDFTK para reparar o PDF
        $command = "pdftk {$inputAbsolutPath} output {$repairedAbsolutPath}";

        //$command = "qpdf {$inputAbsolutPath} --replace-input";
        //$repairedPdf = $inputPdf;

        Log::channel('stderr')->info("::::::::::::::command: $command");
        // Executa o comando de reparo
        exec($command);

        return $repairedPdf;
    }
}