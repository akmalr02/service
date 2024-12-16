<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgresController;
use App\Http\Controllers\ServiceStatusController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');
Route::get('/logout', [LoginController::class, 'logout']);

//route dashboard
Route::get('homeAdmin', [DashboardController::class, 'admin'])->middleware('auth')->name('homeAdmin');
Route::get('homeAuth', [DashboardController::class, 'auth'])->middleware('auth')->name('homeAuth');
// Route::get('hometeknisi', [DashboardController::class, 'teknisi'])->middleware('auth')->name('homeTeknisi');

//route untuk teknisi
Route::get('tugas', [TugasController::class, 'teknisi'])->middleware('auth')->name('tugas.index');
Route::get('tugas/{id}', [TugasController::class, 'show'])->middleware('auth')->name('tugas.show');
Route::post('/tugas/{id}/ambil', [TugasController::class, 'takeTask'])->name('tugas.take');

route::resource('progres', ProgresController::class)->middleware('auth');

// route untuk admin
Route::resource('status', ServiceStatusController::class)->middleware('auth');

Route::resource('user', UserController::class)->middleware('auth');

Route::get('tickets', [TicketsController::class, 'index'])->middleware('auth');
Route::patch('/tickets/{id}/pay', [TicketsController::class, 'pay'])->name('tickets.pay');
Route::patch('/tickets/{id}/forward-to-technical', [TicketsController::class, 'forwardToTechnical'])->name('tickets.forwardToTechnical');

Route::resource('service', ServiceController::class)->middleware('auth');
