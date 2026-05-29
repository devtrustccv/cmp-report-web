<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CompraVendaController,
    IupRemForoController,
    AtestadoController,
    DoacaoController,
    PartilhaController,
    TerrenoController,
    DocumentController,
    CertidaoMatricialController,
    IupController
};

Route::prefix('/')->group(function () {

    Route::get('compra-venda/{id}', [IupController::class, 'gerarPdf']);
    Route::get('iupremforo/{id}', [IupController::class, 'gerarPdf']);
    Route::get('iuppartilha/{id}', [IupController::class, 'gerarPdf']);
    Route::get('iupdoacao/{id}', [IupController::class, 'gerarPdf']);
    Route::get('iupterreno/{id}', [IupController::class, 'gerarPdf']);
    Route::get('document-link-public/{id}', [DocumentController::class, 'loadDocument']);
    Route::get('reports/certidao-matricial/{id}', [CertidaoMatricialController::class, 'gerarPdf']);
    

});

Route::get('/atestado', [AtestadoController::class, 'gerarPdf'])
    ->name('atestado.gerarPdf');


