<?php

namespace App\Models;

class ImpostoCirculacaoDto
{
    public ?int $id = null;
    public ?string $numero = null;

    // Características do veículo
    public ?string $especie = null;        // AUTOMOVEL | MOTOCICLOS
    public ?string $cilindrada = null;     // chave de uma das faixas fixas (ver view)
    public ?string $matricula = null;
    public ?string $anoMatricula = null;

    // Marca do veículo
    public ?string $marcaCategoria = null; // AUTOMOVEL | MOTOCICLOS
    public ?string $marca = null;          // nome da marca (deve corresponder a uma das opções fixas) ou null para "outra"
    public ?string $outraMarca = null;

    // Proprietário do veículo
    public ?string $proprietarioNome = null;
    public ?string $proprietarioResidencia = null;

    // Elementos sobre o imposto
    public ?string $ano = null;
    public ?string $disticoSerie = null;
    public ?string $disticoNumero = null;
    public float $taxaValor = 0;
    public float $taxaImpresso = 0;
    public float $taxaJuros = 0;
    public float $taxaTotal = 0;

    public ?string $registoNumero = null;
    public ?string $dataRegisto = null;

    public ?string $cobradoPor = null;
    public ?string $dataEmissao = null;

    // Dados de pagamento / validação
    public ?string $referencia = null;
    public ?string $entidade = '112';
    public ?string $codigoBarra = null;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->numero = $data['numero'] ?? null;

        $this->especie = $data['especie'] ?? null;
        $this->cilindrada = $data['cilindrada'] ?? null;
        $this->matricula = $data['matricula'] ?? null;
        $this->anoMatricula = $data['anoMatricula'] ?? null;

        $this->marcaCategoria = $data['marcaCategoria'] ?? null;
        $this->marca = $data['marca'] ?? null;
        $this->outraMarca = $data['outraMarca'] ?? null;

        $this->proprietarioNome = $data['proprietarioNome'] ?? null;
        $this->proprietarioResidencia = $data['proprietarioResidencia'] ?? null;

        $this->ano = $data['ano'] ?? null;
        $this->disticoSerie = $data['disticoSerie'] ?? null;
        $this->disticoNumero = $data['disticoNumero'] ?? null;
        $this->taxaValor = (float) ($data['taxaValor'] ?? 0);
        $this->taxaImpresso = (float) ($data['taxaImpresso'] ?? 0);
        $this->taxaJuros = (float) ($data['taxaJuros'] ?? 0);
        $this->taxaTotal = (float) ($data['taxaTotal'] ?? 0);

        $this->registoNumero = $data['registoNumero'] ?? null;
        $this->dataRegisto = $data['dataRegisto'] ?? null;

        $this->cobradoPor = $data['cobradoPor'] ?? null;
        $this->dataEmissao = $data['dataEmissao'] ?? null;

        $this->referencia = $data['referencia'] ?? null;
        $this->entidade = $data['entidade'] ?? '112';
        $this->codigoBarra = $data['codigoBarra'] ?? null;
    }
}
