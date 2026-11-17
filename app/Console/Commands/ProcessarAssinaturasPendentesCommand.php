<?php

namespace App\Console\Commands;

class ProcessarAssinaturasPendentesCommand extends ProcessarAssinaturasBaseCommand
{
    protected $signature = 'assinaturas:processar-pendentes';

    protected $description = 'Assina os registos PENDENTE (todos exceto tipoDoc = RENOVACAO_ALVARA) e atualiza o status para SUCESSO/ERRO.';

    // Todos menos RENOVACAO_ALVARA (esse tem job próprio: assinaturas:processar-renovacao-alvara).
    protected function filtrosApi(): array
    {
        return ['tipoDocExcluir' => self::TIPO_RENOVACAO_ALVARA];
    }

    protected function filtrar(array $registo): bool
    {
        return !self::isRenovacaoAlvara($registo);
    }

    protected function assinar(array $registo): array
    {
        return $this->processorService->processar([
            'file_id' => $registo['docId'],
            'signature_id' => $registo['imgAssinaturaId'] ?? null,
            'position' => $registo['positionAssinatura'],
            'nome_assinatura' => $registo['nomeAssinatura'],
            'contraprova' => $registo['contraprova'] ?? '',
            'numero_processo' => $registo['numeroProcesso'],
            'link' => $registo['linkValidacao'] ?? null,
            'pelo' => $registo['pelo'] ?? '',
            'competencia' => $registo['complemento'] ?? '',
        ]);
    }
}
