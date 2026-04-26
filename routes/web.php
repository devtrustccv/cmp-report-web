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
    CertidaoMatricialController
};

Route::prefix('/')->group(function () {

    Route::get('compra-venda/{id}', [CompraVendaController::class, 'gerarPdf']);
    Route::get('iupremforo/{id}', [IupRemForoController::class, 'gerarPdf']);
    Route::get('iuppartilha/{id}', [PartilhaController::class, 'gerarPdf']);
    Route::get('iupdoacao/{id}', [DoacaoController::class, 'gerarPdf']);
    Route::get('iupterreno/{id}', [TerrenoController::class, 'gerarPdf']);
    Route::get('document-link-public/{id}', [DocumentController::class, 'loadDocument']);
    Route::get('reports/certidao-matricial', [CertidaoMatricialController::class, 'gerarPdf']);
    

});

Route::get('/atestado', [AtestadoController::class, 'gerarPdf'])
    ->name('atestado.gerarPdf');


