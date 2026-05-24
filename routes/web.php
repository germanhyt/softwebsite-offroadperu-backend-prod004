<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/dashboard/login');
});


Route::get('/excel/clientes', function () {
    return view('excel');
});
