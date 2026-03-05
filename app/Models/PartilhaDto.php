<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartilhaDto extends Model
{
    // Não usa tabela nem timestamps
    public $timestamps = false;
    protected $table = null;

    public $id;
    public $matriz;
    public $fraccao;
    public $antigosProprietarios;
    public $tipoTransmissao;
    public $data_emissao;
    public $numTransmissao;
    public $ducComprador;
    public $ducVendedor;
    public $dividaComprador;
    public $dividaDevedor;
    public $valorInicial;
    public $valorFinal;
    public $valorTransaccao;
    public $isencao;
    public $impAPagar;
    public $data_pagamento;
    public $cobrado_por;
    public $norte;
    public $sul;
    public $este;
    public $oeste;
    public $descMatriz;
    public $extenso;
    public $novosProprietarios;
    public $numPrestacao;
    public $total_pago;
    public $totalPrestacoes;
    public $infoPrestacoes;
    public $codigoBarra;
    public $titulo;
    public $numero_processo;
    public $tipoDuc;
    public $duc;
    public $meioPagamento;
    public $emitido_por;

    
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