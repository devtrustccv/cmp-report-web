<?php

namespace App\Models;

class AssinaturaDto
{
    
    public string $nomeAssina;
    public string $mimeType;
    public string $assinatura;
    public ?string $dataRegisto;
    public ?string $dataEliminado;


    // ===== Dados do Pedido =====
    public ?int $pedidoId = null;
    public ?int $userIdPedido = null;
    public ?int $atestadoAssindadoId = null;

    public ?string $nome = null;
    public ?string $filiacao = null;
    public ?string $estadoCivil = null;
    public ?string $tipoPedido = null;
    public ?string $codigo = null;
    public ?string $codBarra = null;
    public ?string $naturalidade = null;
    public ?string $tipoDocumento = null;
    public ?string $numeroDocumento = null;
    public ?string $residencia = null;
    public ?string $efeito = null;
    public ?string $texto = null;
    public ?string $agregado = null;
    public ?string $numeroPedido = null;

// ===== Delegação =====
public ?string $delegacaoDirecao = null;


    public function __construct(array $data)
    {
        $this->nomeAssina = $data['nomeAssina'];
        $this->mimeType = $data['mimeType'];
        $this->assinatura = $data['assinatura'];
        $this->dataRegisto = $data['dataRegisto'] ?? null;
        $this->dataEliminado = $data['dataEliminado'] ?? null;

        // Pedido
        $this->pedidoId = $data['pedidoId'] ?? null;
        $this->userIdPedido = $data['userId'] ?? null;
        $this->atestadoAssindadoId = $data['atestadoAssindadoId'] ?? null;

        $this->nome = $data['nome'] ?? null;
        $this->filiacao = $data['filiacao'] ?? null;
        $this->estadoCivil = $data['estadoCivil'] ?? null;
        $this->tipoPedido = $data['tipoPedido'] ?? null;
        $this->codigo = $data['codigo'] ?? null;
        $this->codBarra = $data['codBarra'] ?? null;
        $this->naturalidade = $data['naturalidade'] ?? null;
        $this->tipoDocumento = $data['tipoDocumento'] ?? null;
        $this->numeroDocumento = $data['numeroDocumento'] ?? null;
        $this->residencia = $data['residencia'] ?? null;
        $this->efeito = $data['efeito'] ?? null;
        $this->texto = $data['texto'] ?? null;
        $this->agregado = $data['agregado'] ?? null;
        $this->numeroPedido=$numeroPedido['numeroPedido'] ?? null;

        // Delegação
        $this->delegacaoDirecao = $data['delegacaoDirecao'] ?? null;

    }

    /**
     * Retorna a assinatura em formato HTML <img>
     */
    public function assinaturaHtml(int $width = 200, int $height = null): string
    {
        $heightAttr = $height ? "height='{$height}px'" : "height='auto'";
        return "<img src='data:{$this->mimeType};base64,{$this->assinatura}' width='{$width}' {$heightAttr} alt='Assinatura'>";
    }
}
