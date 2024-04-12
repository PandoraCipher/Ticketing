<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/main', function(){
    return view('layouts/main');
});

Route::get('/list', function (){
    return view('tickets/list');
});

Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.list');