<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermutaDto extends Model
{
    // Não usa base de dados
    public $timestamps = false;
    protected $table = null;

    public $duc;
    public $id;
    public $data_emissao;
    public $dtEscritura;
    public $numero_processo;
    public $local;

    // Permutante 1 e respectivo imóvel entregue por ele
    public $permutante1;
    public $matriz1;
    public $fraccao1;
    public $superficie1;
    public $descMatriz1;
    public $norte1;
    public $sul1;
    public $este1;
    public $oeste1;

    // Permutante 2 e respectivo imóvel entregue por ele
    public $permutante2;
    public $matriz2;
    public $fraccao2;
    public $superficie2;
    public $descMatriz2;
    public $norte2;
    public $sul2;
    public $este2;
    public $oeste2;

    // Torna (diferença de valores paga entre permutantes, quando aplicável)
    public $torna;
    public $tornaBeneficiario;
    public $tornaExtenso;

    // Valores/tributação (IUP)
    public $valorInicial;
    public $valorFinal;
    public $valorTransaccao;
    public $baseIncidencia;
    public $isencao;
    public $impAPagar;
    public $multa;
    public $juro;
    public $total_pago;
    public $totalExtenso;
    public $dividaComprador;
    public $dividaDevedor;

    public $cobrado_por;
    public $data_pagamento;
    public $meioPagamento;
    public $utilizadorTrm;
    public $dataEmissaoRequisicao;
    public $estado;
    public $codigoBarra;
    public $anoEscritura;
    public $titulo;
    public $tipoDuc;
    public $emitido_por;

    // Construtor para popular via JSON ou array
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
