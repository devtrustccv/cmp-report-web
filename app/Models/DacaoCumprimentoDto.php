<?php

namespace App\Models;

/**
 * Dação em cumprimento: mesmos campos da compra e venda.
 * No relatório, "vendedor" (antigo proprietário) aparece como Dador
 * e "comprador" (novo proprietário) como Receptor.
 */
class DacaoCumprimentoDto extends CompraVenda
{
}
