<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompraVendaController;
use App\Http\Controllers\IupRemForoController;

Route::get('/compra-venda/{id}', [CompraVendaController::class, 'gerarPdf']);
Route::get('/iupremforo/{id}', [IupRemForoController::class, 'gerarPdf']);



