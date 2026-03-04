<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompraVendaController;
use App\Http\Controllers\IupRemForoController;
use App\Http\Controllers\AtestadoController;
use App\Http\Controllers\DoacaoController;
use App\Http\Controllers\PartilhaController;

Route::get('/compra-venda/{id}', [CompraVendaController::class, 'gerarPdf']);
Route::get('/iupremforo/{id}', [IupRemForoController::class, 'gerarPdf']);
Route::get('/iuppartilha/{id}', [PartilhaController::class, 'gerarPdf']);
Route::get('/iupdoacao/{id}', [DoacaoController::class, 'gerarPdf']);



// Atestado - parâmetros via query string
Route::get('/atestado', [AtestadoController::class, 'gerarPdf'])
     ->name('atestado.gerarPdf');


