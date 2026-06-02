<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\BasicMethods;

class SucessorioController extends Controller
{
    public function index(int $id)
    {
        //$dados = $this->appService->getSucessorio($id);

        return BasicMethods::renderPdf(
            'sucessorio',
            [
                'dados' => []
            ],
            'sucessorio.pdf'
        );
    }
}