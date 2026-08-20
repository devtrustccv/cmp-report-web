<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SucessorioDto extends Model
{
    // Não usa base de dados
    public $timestamps = false;
    protected $table = null;

    public $duc;
    public $id;
    public $matriz;
    public $fraccao;
    public $superficie;
    public $antigosProprietarios;
    public $tipoTransmissao;
    public $data_emissao;
    public $numTransmissao;
    public $novosProprietarios;
    public $ducComprador;
    public $multa;
    public $juro;
    public $dtEscritura;
    public $ducVendedor;
    public $dividaComprador;
    public $total;
    public $totalExtenso;
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
    public $local;
    public $numero_processo;
    public $utilizadorTrm;
    public $dataEmissaoRequisicao;
    public $meioPagamento;
    public $estado;
    public $codigoBarra;
    public $anoEscritura;
    public $titulo;
    public $tipoDuc;


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
