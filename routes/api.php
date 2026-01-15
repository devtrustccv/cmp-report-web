<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompraVendaController;
use App\Http\Controllers\RelatorioController;

Route::get('/compra-venda', [CompraVendaController::class, 'gerarPdf']);


