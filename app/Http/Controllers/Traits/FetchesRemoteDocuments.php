<?php

namespace App\Http\Controllers\Traits;

use App\Services\AppService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait FetchesRemoteDocuments
{
    /**
     * Busca um documento pelo ID na API e grava-o na disk 'public', devolvendo o caminho.
     */
    protected function storeRemoteDocument(AppService $appService, int $id, string $directory): string
    {
        $document = $appService->getDocumentBinary($id);

        $extension = $this->extensionFromMimeType($document['mimeType']) ?? 'bin';

        $path = trim($directory, '/') . '/' . Str::uuid() . '.' . $extension;

        Storage::disk('public')->put($path, $document['content']);

        return $path;
    }

    private function extensionFromMimeType(?string $mimeType): ?string
    {
        return match ($mimeType) {
            'application/pdf' => 'pdf',
            'image/png' => 'png',
            'image/jpeg', 'image/jpg' => 'jpg',
            'image/gif' => 'gif',
            default => null,
        };
    }
}
