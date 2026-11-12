<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Espelho do CertidaoLicenciamentoDTO (API Java) usado por todos os reports
 * do Licenciamento Comercial. O report a gerar é escolhido pelo $codigo.
 */
class CertidaoLicenciamentoDto
{
    public ?int $id = null;
    public ?string $nrPedido = null;
    public ?string $nrCertidao = null;
    public ?string $validadeMes = null;
    public ?string $codigo = null;
    public ?string $descricao = null;
    public ?string $fins = null;
    public ?string $dataRegisto = null;
    public ?string $nAlvara = null;
    public ?string $nrCartao = null;
    public ?string $nrPrestacao = null;
    public ?string $nome = null;
    public ?string $tipoDocumento = null;
    public ?string $nrDocumento = null;

    private const EXTENSO = [
        1 => 'um', 2 => 'dois', 3 => 'três', 4 => 'quatro', 5 => 'cinco', 6 => 'seis',
        7 => 'sete', 8 => 'oito', 9 => 'nove', 10 => 'dez', 11 => 'onze', 12 => 'doze',
    ];

    public function __construct(array $data = [])
    {
        // A API pode enviar o texto "null" ou strings vazias: tratar como null
        $data = array_map(
            fn ($v) => is_string($v) && in_array(strtolower(trim($v)), ['', 'null'], true) ? null : $v,
            $data
        );

        $this->id            = isset($data['id']) ? (int) $data['id'] : null;
        $this->nrPedido      = $data['nrPedido'] ?? null;
        $this->nrCertidao    = $data['nrCertidao'] ?? null;
        $this->validadeMes   = isset($data['validadeMes']) ? (string) $data['validadeMes'] : null;
        $this->codigo        = $data['codigo'] ?? null;
        $this->descricao     = $data['descricao'] ?? null;
        $this->fins          = $data['fins'] ?? null;
        $this->dataRegisto   = $data['dataRegisto'] ?? null;
        // getNAlvara() pode ser serializado como "nAlvara", "NAlvara" ou "nalvara" conforme o Jackson
        $this->nAlvara       = $data['nAlvara'] ?? $data['NAlvara'] ?? $data['nalvara'] ?? null;
        $this->nrCartao      = $data['nrCartao'] ?? null;
        $this->nrPrestacao   = $data['nrPrestacao'] ?? null;
        $this->nome          = $data['nome'] ?? null;
        $this->tipoDocumento = $data['tipoDocumento'] ?? null;
        $this->nrDocumento   = $data['nrDocumento'] ?? null;
    }

    /** Ex.: "03 (três)" */
    public function validadeTexto(): string
    {
        $n = (int) $this->validadeMes;

        if ($n <= 0) {
            return '';
        }

        return str_pad((string) $n, 2, '0', STR_PAD_LEFT) . ' (' . (self::EXTENSO[$n] ?? $n) . ')';
    }

    public function finsTexto(): string
    {
        return $this->fins ?: 'fins convenientes';
    }

    /**
     * Separa os titulares quando a API envia vários valores separados por ";":
     *   nome          = "Fernanda Maria Correia Semedo; Angelo Maria Varela Semedo"
     *   tipoDocumento = "BI/CNI;BI/CNI"
     *   nrDocumento   = "95929;8291"
     * Se vier só um tipo de documento, é usado para todos os titulares.
     *
     * @return array<int, array{nome: string, tipoDocumento: ?string, nrDocumento: ?string}>
     */
    public function titulares(): array
    {
        $nomes   = self::separar($this->nome);
        $tipos   = self::separar($this->tipoDocumento);
        $numeros = self::separar($this->nrDocumento);

        $titulares = [];

        foreach ($nomes as $i => $nome) {
            $titulares[] = [
                'nome'          => $nome,
                'tipoDocumento' => $tipos[$i] ?? (count($tipos) === 1 ? $tipos[0] : null),
                'nrDocumento'   => $numeros[$i] ?? null,
            ];
        }

        return $titulares;
    }

    public function temVariosTitulares(): bool
    {
        return count($this->titulares()) > 1;
    }

    /**
     * Texto (HTML) com os titulares, nomes a negrito:
     *   1 titular  -> "<b>Fernanda ...</b>, BI/CNI – 95929"
     *   2 ou mais  -> "<b>Fernanda ...</b>, BI/CNI – 95929 e <b>Angelo ...</b>, BI/CNI – 8291"
     *   3 ou mais  -> "<b>A</b>, doc; <b>B</b>, doc e <b>C</b>, doc"
     * Usar na view com {!! !!} (os valores já vêm escapados).
     */
    public function titularesTexto(): string
    {
        $partes = array_map(function (array $t) {
            $texto = '<strong>' . e($t['nome']). ',</strong>';

            if (!empty($t['nrDocumento'])) {
                $doc = trim(($t['tipoDocumento'] ?? '') . ' – ' . $t['nrDocumento'], ' –');
                $texto .= ' ' . e($doc);
            }

            return $texto;
        }, $this->titulares());

        if (count($partes) <= 1) {
            return $partes[0] ?? '';
        }

        $ultimo = array_pop($partes);

        return implode('; ', $partes) . ' e ' . $ultimo;
    }

    /** Escolhe a forma singular/plural conforme o nº de titulares. Ex.: $dados->conforme('é titular', 'são titulares') */
    public function conforme(string $singular, string $plural): string
    {
        return $this->temVariosTitulares() ? $plural : $singular;
    }

    /** @return string[] */
    private static function separar(?string $valor): array
    {
        if ($valor === null) {
            return [];
        }

        return array_values(array_filter(
            array_map('trim', explode(';', $valor)),
            fn ($v) => $v !== '' && strtolower($v) !== 'null'
        ));
    }

    /** dataRegisto em dd/mm/aaaa (aceita "dd-mm-aaaa", "dd/mm/aaaa", "aaaa-mm-dd" ou ISO com hora) */
    public function dataRegistoFormatada(): string
    {
        $data = self::parseData($this->dataRegisto);

        return $data ? $data->format('d/m/Y') : '';
    }

    /** Data de emissão do documento por extenso: "26 de agosto de 2026" */
    public static function dataEmissaoExtenso(?Carbon $data = null): string
    {
        return ($data ?? Carbon::now())->locale('pt')->translatedFormat('d \d\e F \d\e Y');
    }

    private static function parseData(?string $valor): ?Carbon
    {
        if (empty($valor)) {
            return null;
        }

        try {
            if (preg_match('#^(\d{2})[/-](\d{2})[/-](\d{4})#', $valor, $m)) {
                return Carbon::createFromDate((int) $m[3], (int) $m[2], (int) $m[1]);
            }

            return Carbon::parse($valor);
        } catch (\Throwable) {
            return null;
        }
    }
}
