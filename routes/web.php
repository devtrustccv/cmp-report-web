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

    Route::get('compra-venda/{id}', [IupController::class, 'getCompraVenda']);
    Route::get('iupremforo/{id}', [IupController::class, 'getRemForo']);
    Route::get('iuppartilha/{id}', [IupController::class, 'getPartilha']);
    Route::get('iupdoacao/{id}', [IupController::class, 'getDoacao']);
    Route::get('iupterreno/{id}', [IupController::class, 'getTerreno']);
    Route::get('document-link-public/{id}', [DocumentController::class, 'loadDocument']);
    Route::get('reports/certidao-matricial/{id}', [CertidaoMatricialController::class, 'gerarCertidaoMatricial']);
    

});


Route::get('/atestado', [AtestadoController::class, 'gerarPdf'])
    ->name('atestado.gerarPdf');


