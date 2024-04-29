<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/main', function(){
    return view('layouts/main');
});

Route::get('/list', function (){
    return view('tickets/list');
});

Route::get('/dashboard', function(){
    return view('dashboard');
})->name('dashboard');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/login', [AuthController::class, 'doLogin']);

Route::prefix('tickets')->middleware(Authenticate::class)->group(function () {
    Route::get('/', [TicketController::class, 'index'])->name('tickets.list');
    Route::get('/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/create', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::put('/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::get('/download/{filename}', [TicketController::class, 'download'])->name('tickets.download');
});

Route::prefix('users')->middleware(Authenticate::class)->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.userlist');
    Route::get('/usercreate', [UserController::class, 'create'])->name('users.usercreate');
    Route::post('/usercreate', [UserController::class, 'store'])->name('users.store');
    Route::get('/{user}', [UserController::class, 'show'])->name('users.usershow');
    Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');

});

