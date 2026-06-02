<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\BasicMethods;

class PermutaController extends Controller
{
    public function index(int $id)
    {
        //$dados = $this->appService->getPermuta($id);

        return BasicMethods::renderPdf(
            'permuta',
            [
                'dados' => [] // $dados
            ],
            'permuta.pdf'
        );
    }
}
