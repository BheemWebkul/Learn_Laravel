<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pipeline-demo', [App\Http\Controllers\PipelineDemoController::class, 'checkout']);
