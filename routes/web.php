<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/main', function () {
    return view('layouts/main');
});

Route::get('/list', function () {
    return view('tickets/list');
});

Route::get('/dashboard', [TicketController::class, 'dashboard'])
    ->name('dashboard')
    ->middleware(Authenticate::class);

Route::get('/setting', [SettingController::class, 'index'])
    ->name('setting')
    ->middleware(Authenticate::class);

Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/login', [AuthController::class, 'doLogin']);
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('auth.signup');
Route::post('/signup', [UserController::class, 'register'])->name('user.signup');

Route::prefix('intervention')
    ->middleware(Authenticate::class)
    ->group(function () {
        Route::get('/', [InterventionController::class, 'index'])->name('intervention.list');
        Route::get('/create', [InterventionController::class, 'create'])->name('intervention.create');
        Route::post('/create', [InterventionController::class, 'store'])->name('intervention.store');
        Route::get('/{intervention}', [InterventionController::class, 'show'])->name('intervention.show');
        Route::put('/{intervention}', [InterventionController::class, 'update'])->name('intervention.update');
        Route::get('/print', [InterventionController::class, 'show'])->name('intervention.print');
    });

Route::prefix('tickets')
    ->middleware(Authenticate::class)
    ->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('tickets.list');
        Route::get('/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/create', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
        Route::put('/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
        Route::get('/download/{filename}', [TicketController::class, 'download'])->name('tickets.download');
    });
Route::get('/export/{ticket}', [TicketController::class, 'exportPDF'])->name('export');
Route::get('/show/{ticket}', [TicketController::class, 'showPDF'])->name('showPDF');

Route::prefix('users')
    ->middleware(Authenticate::class)
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.userlist');
        Route::get('/usercreate', [UserController::class, 'create'])->name('users.usercreate');
        Route::post('/usercreate', [UserController::class, 'store'])->name('users.store');
        Route::get('/{user}', [UserController::class, 'show'])->name('users.usershow');
        Route::put('/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

Route::prefix('status')
->middleware(Authenticate::class)
->group(function (){
    Route::get('/statuscreate', [StatusController::class, 'create'])->name('status.statuscreate');
    Route::post('/statuscreate', [StatusController::class, 'store'])->name('status.store');
    Route::delete('/{status}', [StatusController::class, 'destroy'])->name('status.destroy');
});

Route::prefix('category')
->middleware(Authenticate::class)
->group(function (){
    Route::get('/categorycreate', [CategoryController::class, 'create'])->name('category.categorycreate');
    Route::post('/categorycreate', [CategoryController::class, 'store'])->name('category.store');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
});

Route::prefix('department')
->middleware(Authenticate::class)
->group(function (){
    Route::get('/departmentcreate', [DepartmentController::class, 'create'])->name('department.statuscreate');
    Route::post('/departmentcreate', [DepartmentController::class, 'store'])->name('department.store');
    Route::delete('/{department}', [DepartmentController::class, 'destroy'])->name('department.destroy');
});
