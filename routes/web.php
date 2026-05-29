<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AtestadoController,
    DocumentController,
    CertidaoMatricialController,
    IupController
};


/**
 * essas são reports para iup ou iti
 */
Route::prefix('/')->group(function () {

    Route::get('compra-venda/{id}', [IupController::class, 'compraVenda']);
    Route::get('iupremforo/{id}', [IupController::class, 'remForo']);
    Route::get('iuppartilha/{id}', [IupController::class, 'partilha']);
    Route::get('iupdoacao/{id}', [IupController::class, 'doacao']);
    Route::get('iupterreno/{id}', [IupController::class, 'terreno']);
    Route::get('document-link-public/{id}', [DocumentController::class, 'loadDocument']);
    Route::get('reports/certidao-matricial/{id}', [CertidaoMatricialController::class, 'gerarCertidaoMatricial']);
    

});


Route::get('/atestado', [AtestadoController::class, 'gerarPdf'])
    ->name('atestado.gerarPdf');


