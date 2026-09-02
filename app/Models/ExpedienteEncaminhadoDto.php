<?php

namespace App\Models;

class ExpedienteEncaminhadoDto
{
    public ?string $dtFase = null;
    public ?string $dtFaseA = null;
    public ?string $nmInterveniente = null;
    public ?string $nmIntervAnt = null;
    public ?string $dsTpPedido = null;
    public ?string $dsFase = null;
    public ?string $pedido = null;
    public ?string $nmEntidade = null;
    public ?string $bairro = null;
    public ?int $nrDias = null;
    public ?string $refCadastral = null;

    public function __construct(array $data = [])
    {
        $this->dtFase = $data['dtFase'] ?? null;
        $this->dtFaseA = $data['dtFaseA'] ?? null;
        $this->nmInterveniente = $data['nmInterveniente'] ?? null;
        $this->nmIntervAnt = $data['nmIntervAnt'] ?? null;
        $this->dsTpPedido = $data['dsTpPedido'] ?? null;
        $this->dsFase = $data['dsFase'] ?? null;
        $this->pedido = $data['pedido'] ?? null;
        $this->nmEntidade = $data['nmEntidade'] ?? null;
        $this->bairro = $data['bairro'] ?? null;
        $this->nrDias = $data['nrDias'] ?? null;
        $this->refCadastral = $data['refCadastral'] ?? null;
    }
}
