<?php

namespace App\Models;

class PredioDeclaradoDto
{
    public ?string $tipoPredio = null;
    public ?string $subzona = null;
    public ?string $quarteirao = null;
    public ?string $lote = null;
    public ?string $area = null;
    public ?string $numMatriz = null;
    public ?string $fraccao = null;

    public function __construct(array $data = [])
    {
        $this->tipoPredio = $data['tipoPredio'] ?? null;
        $this->subzona = $data['subzona'] ?? null;
        $this->quarteirao = $data['quarteirao'] ?? null;
        $this->lote = $data['lote'] ?? null;
        $this->area = $data['area'] ?? null;
        $this->numMatriz = $data['numMatriz'] ?? null;
        $this->fraccao = $data['fraccao'] ?? null;
    }
}
