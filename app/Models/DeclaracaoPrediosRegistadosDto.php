<?php

namespace App\Models;

class DeclaracaoPrediosRegistadosDto
{
    public ?int $id = null;
    public ?string $direcao = null;
    public ?string $despacho = null;
    public ?string $localizacao = null;
    public ?string $titular = null;
    public ?string $utilizador = null;
    public ?string $dataEmissao = null;

    /** @var PredioDeclaradoDto[] */
    public array $predios = [];

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->direcao = $data['direcao'] ?? null;
        $this->despacho = $data['despacho'] ?? null;
        $this->localizacao = $data['localizacao'] ?? null;
        $this->titular = $data['titular'] ?? null;
        $this->utilizador = $data['utilizador'] ?? null;
        $this->dataEmissao = $data['dataEmissao'] ?? null;

        $this->predios = array_map(
            fn ($item) => new PredioDeclaradoDto($item),
            $data['predios'] ?? []
        );
    }
}
