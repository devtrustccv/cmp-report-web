<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssinaturaController;

Route::post('/sign_document', [AssinaturaController::class, 'signPdfDocument']);
Route::post('/merge_pdf', [AssinaturaController::class, 'mergePDFs']);


