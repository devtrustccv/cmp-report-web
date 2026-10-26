<?php

namespace App\Models;

class ListaPedidoItemDto
{
    public ?int $pedidoId = null;
    public ?string $nrPedido = null;
    public ?int $tpPedidoId = null;
    public ?string $dsTpPedido = null;
    public ?string $dtPedido = null;
    public ?string $dtPedidoA = null;
    public ?string $nmEntidade = null;
    public ?string $qualidade = null;
    public ?string $refCadastral = null;
    public ?string $dsFase = null;
    public ?string $nmInterveniente = null;
    public ?string $bairro = null;
    public ?string $nmIntervAnt = null;
    public ?int $nrDias = null;

    public function __construct(array $data = [])
    {
        $this->pedidoId = $data['pedidoId'] ?? null;
        $this->nrPedido = $data['nrPedido'] ?? null;
        $this->tpPedidoId = $data['tpPedidoId'] ?? null;
        $this->dsTpPedido = $data['dsTpPedido'] ?? null;
        $this->dtPedido = $data['dtPedido'] ?? null;
        $this->dtPedidoA = $data['dtPedidoA'] ?? null;
        $this->nmEntidade = $data['nmEntidade'] ?? null;
        $this->qualidade = $data['qualidade'] ?? null;
        $this->refCadastral = $data['refCadastral'] ?? null;
        $this->dsFase = $data['dsFase'] ?? null;
        $this->nmInterveniente = $data['nmInterveniente'] ?? null;
        $this->bairro = $data['bairro'] ?? null;
        $this->nmIntervAnt = $data['nmIntervAnt'] ?? null;
        $this->nrDias = $data['nrDias'] ?? null;
    }
}
