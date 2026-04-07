<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TerrenoDto extends Model
{
    public $nomeRequerente;
    public $comprador;
    public $regime;
    public $vendedor;
    public $matriz;
    public $fraccao;
    public $totalOnline;
    public $valor;
    public $norte;
    public $sul;
    public $este;
    public $oeste;
    public $descricao;
    public $estenso;
    public $local;
    public $morada;
    public $nome;
    public $bi;
    public $prestacao;
    public $superficie;
    public $cobrado_por;
    public $juro;
    public $sisa;
    public $rendimento;
    public $duc;
    public $total_pago;
    public $meioPagamento;
    public $data_pagamento;
    public $numero_processo;
    public $emitido_por;
    public $estado;
    public $data_emissao;

    // Construtor para popular o model com JSON ou array
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}