<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AtestadoController,
    DocumentController,
    CertidaoMatricialController,
    IupController,
    SucessorioController,
    PermutaController
};


/**
 * essas são reports para iup ou iti
 */
Route::prefix('/')->group(function () {

    Route::get('compra-venda/{token}', [IupController::class, 'compraVenda']);
    Route::get('iupremforo/{token}', [IupController::class, 'remForo']);
    Route::get('iuppartilha/{token}', [IupController::class, 'partilha']);
    Route::get('iupdoacao/{token}', [IupController::class, 'doacao']);
    Route::get('iupterreno/{token}', [IupController::class, 'terreno']);
    Route::get('document-link-public/{id}', [DocumentController::class, 'loadDocument']);
    Route::get('reports/certidao-matricial/{token}', [CertidaoMatricialController::class, 'gerarCertidaoMatricial']);
    Route::get('sucessorio/{id}', [SucessorioController::class, 'index']);
    Route::get('permuta/{id}', [PermutaController::class, 'index']);

});


Route::get('/', function () { return view('home_cmp');
})->name('home');


Route::get('/atestado/{token}', [AtestadoController::class, 'gerarPdf'])
    ->name('atestado.gerarPdf');


