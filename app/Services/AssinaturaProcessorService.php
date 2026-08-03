<?php

namespace App\Services;

use App\Http\Controllers\Traits\FetchesRemoteDocuments;

class AssinaturaProcessorService
{
    use FetchesRemoteDocuments;

    public function __construct(
        private readonly PdfStampService $pdfStampService,
        private readonly AppService $appService,
    ) {
    }

    /**
     * Busca o documento (e assinatura) remotos, aplica o stamp e envia o PDF assinado.
     *
     * @param array{
     *     file_id: int,
     *     signature_id?: int|null,
     *     signature_url?: string|null,
     *     position: string,
     *     nome_assinatura: string,
     *     contraprova?: string|null,
     *     numero_processo: string,
     *     link?: string|null,
     *     pelo?: string|null,
     *     competencia?: string|null,
     * } $dados
     */
    public function processar(array $dados): array
    {
        $filePath = $this->storeRemoteDocument($this->appService, (int) $dados['file_id'], 'uploads/documents');

        $signaturePath = null;
        if (!empty($dados['signature_id'])) {
            $signaturePath = $this->storeRemoteDocument($this->appService, (int) $dados['signature_id'], 'uploads/signature');
        }

        $stampedContent = $this->pdfStampService->cleanAndSignPDF(
            $filePath,
            $signaturePath,
            $dados['signature_url'] ?? '',
            $dados['position'],
            $dados['nome_assinatura'],
            $dados['contraprova'] ?? '',
            $dados['numero_processo'],
            $dados['link'] ?? null,
            $dados['pelo'] ?? '',
            $dados['competencia'] ?? ''
        );

        return $this->appService->uploadDocument($stampedContent, "documento_assinado_{$dados['numero_processo']}.pdf");
    }
}
