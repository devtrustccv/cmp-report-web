<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response; // Importar Storage facade
use Illuminate\Support\Facades\Validator;
use App\Services\PdfStampService;
use App\Services\AppService;
use App\Http\Controllers\Traits\FetchesRemoteDocuments;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AssinaturaController extends Controller
{
    use FetchesRemoteDocuments;

    protected $pdfStampService;
    protected $appService;

    // Injeção da dependência PdfStampService e AppService
    public function __construct(PdfStampService $pdfStampService, AppService $appService)
    {
        $this->pdfStampService = $pdfStampService;
        $this->appService = $appService;
    }

    public function signPdfDocument(Request $request) {

        ini_set('default_charset', 'UTF-8');

        // validar entrada de dados
        $validator = Validator::make($request->all(), [
            'p_signature_id' => 'integer|prohibits:p_signature_url', // ID da assinatura na API de documentos
            'p_signature_url' => 'prohibits:p_signature_id', // Assinatura por URL direta
            'p_file_id' => 'required|integer', // ID do documento (PDF) na API de documentos
            'p_nome_assinatura' => 'required|string|max:255',
            'p_position' => 'required|string|max:60',
            'p_contraporva' => 'string|max:100',
            'p_numero_processo' => 'required|string|max:100',
            'p_link'=> 'max:400',
            'p_pelo'=> 'max:100',
            'p_competencia' => 'max:400'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        } elseif (!$request->get('p_signature_id') && !$request->get('p_signature_url')) {
            return response()->json(['errors' =>['signature'=>'p_signature_id or p_signature_url is required.']]);
        }

        $contraprova=$request->get('p_contraprova');
        $signature_url = $request->get('p_signature_url') ?? '';
        $position=$request->get('p_position');
        $numero_processo=$request->get('p_numero_processo');
        $nome_assinatura=$request->get('p_nome_assinatura');
        $link=$request->get('p_link');
        $pelo=$request->get('p_pelo');
        $competencia=$request->get('p_competencia');

        try {
            $filePath = $this->storeRemoteDocument($this->appService, (int) $request->get('p_file_id'), 'uploads/documents');

            $signaturePath = null;
            if ($request->get('p_signature_id')) {
                $signaturePath = $this->storeRemoteDocument($this->appService, (int) $request->get('p_signature_id'), 'uploads/signature');
            }

            $stampedContent = $this->pdfStampService->cleanAndSignPDF($filePath, $signaturePath, $signature_url, $position, $nome_assinatura, $contraprova, $numero_processo, $link, $pelo, $competencia);

            $resultado = $this->appService->uploadDocument($stampedContent, "documento_assinado_{$numero_processo}.pdf");
        } catch (\Exception $e) {
            Log::channel('pdfstamper')->error("Erro ao assinar/enviar documento: " . $e->getMessage());

            return response()->json([
                'erro' => 'Erro ao assinar ou enviar o documento.',
                'mensagem' => $e->getMessage()
            ], 400);
        }

        return response()->json($resultado);
    }

    public function mergePDFs(Request $request) {
       //dd($request->allFiles());
        $validator = Validator::make($request->all(), [
            //'p_file' => 'required|mimes:pdf|max:10000', // Documento deve ser um PDF, max_size:10M
            'pdfs' => 'required|array',
            'pdfs.*' => 'required|file|mimes:pdf',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        }

        $files = $request->file('pdfs');

        $paths = [];
        foreach ($files as $file) {
            $stored = $file->storeAs('uploads/documents', 'merging_'.Str::uuid() . '.pdf', 'public');
            $paths[] = $stored;
            Log::channel('stderr')->info("files...".$stored);
        }

        $this->pdfStampService->mergePdfs($paths,);

        return response()->json([
            'success' => true,
            //'merged_pdf' => $outputPath,
        ]);
    }
}
