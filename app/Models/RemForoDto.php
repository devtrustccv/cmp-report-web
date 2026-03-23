<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemForoDto extends Model
{

    public $remiRequerente;
    public $obs;
    public $emols;
    public $remiTaxa;
    public $area;
    public $remiResidencia;
    public $localizacao;
    public $refCadastral;
    public $remiDuc;
    public $ficha;
    public $duc;
    public $estado;
    public $total_pago;
    public $data_emissao;
    public $ano;
    public $mes;
    public $data_pagamento;
    public $totalExtenso;
    public $cobrado_por;
    public $emitido_por;
    public $meioPagamento;
    public $codigoBarra;
    public $fraccao;
    public $matriz;
    public $descricao;

    // Construtor para popular com array ou JSON
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    // Converter para array (útil para API/JSON)
    public function toArray()
    {
        return get_object_vars($this);
    }
}