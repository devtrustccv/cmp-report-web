<?php

namespace App\Console\Commands;

class ProcessarRenovacaoAlvaraCommand extends ProcessarAssinaturasBaseCommand
{
    protected $signature = 'assinaturas:processar-renovacao-alvara';

    protected $description = 'Assina os registos PENDENTE com tipoDoc = RENOVACAO_ALVARA (assinatura no último retângulo "RENOVADO ATÉ") e atualiza o status para SUCESSO/ERRO.';

    // Só RENOVACAO_ALVARA.
    protected function filtrosApi(): array
    {
        return ['tipoDoc' => self::TIPO_RENOVACAO_ALVARA];
    }

    protected function filtrar(array $registo): bool
    {
        return self::isRenovacaoAlvara($registo);
    }

    protected function assinar(array $registo): array
    {
        return $this->processorService->processarRenovacaoAlvara([
            'file_id' => $registo['docId'],
            'signature_id' => $registo['imgAssinaturaId'] ?? null,
            'numero_processo' => $registo['numeroProcesso'],
        ]);
    }
}
