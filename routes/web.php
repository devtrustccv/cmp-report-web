<?php

use Illuminate\Support\Facades\Route;

Route::get('/certidao', function () {
     return view('certidao_matricial');
});

Route::get('/iupremforo', function () {
     return view('iupremforo');
});
