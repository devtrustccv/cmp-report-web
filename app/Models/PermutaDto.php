<?php

namespace App\Models;

use Carbon\Carbon;
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
    public $valorMatriz1;
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
    public $valorMatriz2;
    public $norte2;
    public $sul2;
    public $este2;
    public $oeste2;

    // Torna (diferença de valores paga entre permutantes, quando aplicável)
    public $torna;
    public $tornaBeneficiario;
    public $tornaPagador;
    public $tornaExtenso;
    public $totalPermuta;

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
    public $tipo;
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

    /**
     * Monta o DTO a partir da lista devolvida pela API (CmpVReciboPermutaEntity).
     * O registo com estadoPagamento = 'Pago' é o lado que pagou a diferença;
     * o outro lado é quem a recebe.
     */
    public static function fromRecibos(array $itens, int $duc): self
    {
        usort($itens, fn ($a, $b) => ($a['ordem'] ?? 0) <=> ($b['ordem'] ?? 0));

        $pago = collect($itens)->first(
            fn ($item) => strcasecmp(trim($item['estadoPagamento'] ?? ''), 'Pago') === 0
        );

        $lado1 = $itens[0];
        $lado2 = $itens[1] ?? [];

        $dto = new self([
            'duc' => $duc,
            'id' => $pago['cmcTrmId'] ?? $lado1['cmcTrmId'] ?? null,
            'data_emissao' => now()->format('d/m/Y'),
            'dtEscritura' => self::formatarData($lado1['dataPermuta'] ?? null),
            'local' => $lado1['localizacao'] ?? null,

            'permutante1' => $lado1['antigosProprietarios'] ?? null,
            'matriz1' => $lado1['numMatriz'] ?? $lado1['matriz'] ?? null,
            'fraccao1' => $lado1['fraccao'] ?? null,
            'superficie1' => $lado1['superficie'] ?? null,
            'descMatriz1' => $lado1['localizacao'] ?? null,
            'valorMatriz1' => $lado1['valorTransmissao'] ?? 0,

            'permutante2' => $lado2['antigosProprietarios'] ?? null,
            'matriz2' => $lado2['numMatriz'] ?? $lado2['matriz'] ?? null,
            'fraccao2' => $lado2['fraccao'] ?? null,
            'superficie2' => $lado2['superficie'] ?? null,
            'descMatriz2' => $lado2['localizacao'] ?? null,
            'valorMatriz2' => $lado2['valorTransmissao'] ?? 0,

            // Base sobre a qual é calculada a percentagem de ITI: diferença entre os valores dos imóveis
            'baseIncidencia' => abs(($lado1['valorTransmissao'] ?? 0) - ($lado2['valorTransmissao'] ?? 0)),

            'totalPermuta' => $lado1['totalPermuta'] ?? null,

            'emitido_por' => $pago['emitido_por'] ?? $lado1['emitido_por'] ?? null,
            'cobrado_por' => $pago['cobrado_por'] ?? $lado1['cobrado_por'] ?? null,
            'data_pagamento' => self::formatarData($pago['data_pagamento'] ?? $lado1['data_pagamento'] ?? null),
            'codigoBarra' => $pago['codigoBarra'] ?? $lado1['codigoBarra'] ?? null,
            'meioPagamento' => $pago['meioPagamento'] ?? $lado1['meioPagamento'] ?? null,
            'numero_processo' => $pago['numero_processo'] ?? $lado1['numero_processo'] ?? null,

            // tipo: tipo do documento (ex: IUPPERMUTA)
            'tipo' => $pago['tipo'] ?? $lado1['tipo'] ?? null,
            // tipoDuc: imposto (ITI / IUP)
            'tipoDuc' => $pago['tipoDuc'] ?? $lado1['tipoDuc'] ?? 'ITI',
            'estado' => $pago ? 'FIM' : 'REQ_PAG',
        ]);

        if ($pago) {
            // Quem pagou é o adquirente do registo pago; o outro lado recebe a diferença
            $recebe = collect($itens)->first(fn ($item) => $item !== $pago) ?? [];

            $dto->torna = $pago['valorAPagar'] ?? 0;
            $dto->total_pago = $pago['valorAPagar'] ?? 0;
            $dto->totalExtenso = \App\Http\Utils::valorPorExtenso((float) $dto->total_pago);
            $dto->tornaPagador = $pago['novosProprietarios'] ?? null;
            $dto->tornaBeneficiario = $recebe['novosProprietarios'] ?? $pago['antigosProprietarios'] ?? null;
        }

        return $dto;
    }

    private static function formatarData(?string $data): ?string
    {
        if (!$data) {
            return null;
        }

        try {
            return Carbon::parse($data)->format('d/m/Y');
        } catch (\Throwable) {
            return $data;
        }
    }
}
