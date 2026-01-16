<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompraVenda extends Model
{
    // Desabilita timestamps e tabela, já que não vamos usar DB
    public $timestamps = false;
    protected $table = null;

    // Atributos que o Model pode ter
    public $multa;
    public $juro;
    public $total_pago;
    public $valor_avalidado;
    public $valor_declarado;
    public $area;
    public $comprador;
    public $vendedor;
    public $descricao;
    public $duc;
    public $matriz;
    public $local;
    public $numero_processo;
    public $data_emissao;
    public $data_pagamento;
    public $emitido_por;
    public $cobrado_por;
    public $estado;
    public $titulo;
    public $extenso;
    public $codigoBarra;
    public $meioPagamento;


    // Construtor para popular o model direto com array (ex: resposta da API)
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }
    }
}
