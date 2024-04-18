<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Middleware\Authenticate;
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

Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/login', [AuthController::class, 'doLogin']);

Route::prefix('tickets')->group(function () {
    Route::get('/', [TicketController::class, 'index'])->name('tickets.list')->middleware(Authenticate::class);
    Route::get('/create', [TicketController::class, 'create'])->name('tickets.create')->middleware(Authenticate::class);
    Route::post('/create', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/{ticket}', [TicketController::class, 'show'])->name('tickets.show')->middleware(Authenticate::class);
    Route::put('/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::get('/download/{filename}', [TicketController::class, 'download'])->name('tickets.download');
});

