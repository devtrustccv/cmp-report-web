<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SucessorioDto extends Model
{
    // Não usa base de dados
    public $timestamps = false;
    protected $table = null;

    public $id;
    public $matriz;
    public $fraccao;
    public $superficie;
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
    public $cobrado_por;
    public $data_pagamento;
    public $norte;
    public $sul;
    public $este;
    public $oeste;
    public $descMatriz;
    public $extenso;
    public $novosProprietarios;
    public $numPrestacao;
    public $total_pago;
    public $valorOnline;
    public $estado;
    public $meioPagamento;
    public $codigoBarra;
    public $titulo;
    public $tipoDuc;
    public $duc;
    public $numero_processo;
    public $emitido_por;
    public $baseIncidencia;
    public $infoPrestacoes;


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
