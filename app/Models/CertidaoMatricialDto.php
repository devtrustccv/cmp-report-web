<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmolumentoDto;

class CertidaoMatricialDto extends Model
{
    public $timestamps = false;
    protected $table = null;

    public $id;
    public $numMatriz;
    public $regime;
    public $fraccao;
    public $tipoPredio;
    public $categoria;
    public $proprietario;
    public $titular;
    public $nif;
    public $local;
    public $rendimento;
    public $rendExt;
    public $superficie;
    public $descricao;
    public $norte;
    public $sul;
    public $este;
    public $oeste;
    public $tipo;
    public $freguesia;
    public $concelho;
    public $data;
    public $estadoCobranca;
    public $quoataDesc;
    public $duc;
    public $estadoDuc;
    public $certidao;
    public $efeito;
    public $requerente;
    public $utilizador;
    public $cobradoPor;
    public $dataCobranca;
    public $dataEmissao;
    public $codigoBarra;
    public $ano;
    public $emolumentos = [];
    public $totalEmolumentos;

    public function __construct(array|string $attributes = [])
    {
        // Se vier JSON string → converte
        if (is_string($attributes)) {
            $attributes = json_decode($attributes, true) ?? [];
        }

        // garante que é array
        if (!is_array($attributes)) {
            $attributes = [];
        }

        foreach ($attributes as $key => $value) {

            if ($key === 'emolumentos') {

                if (is_array($value)) {
                    $this->emolumentos = array_map(
                        fn ($item) => is_array($item) ? new EmolumentoDto($item) : null,
                        $value
                    );
                }

                continue;
            }

            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}