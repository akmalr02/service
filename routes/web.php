<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\laporanController;
use App\Http\Controllers\ProgresController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;


Route::get('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/registrasi', [RegisterController::class, 'registrasi'])->name('register.registrasi')->middleware('guest');
Route::post('/registrasi', [RegisterController::class, 'store'])->name('register.store')->middleware('guest');

//route dashboard
Route::get('homeAdmin', [DashboardController::class, 'admin'])->middleware('auth')->name('homeAdmin');
Route::get('homeAuth', [DashboardController::class, 'auth'])->middleware('auth')->name('homeAuth');

//route untuk teknisi
Route::get('tugas', [TugasController::class, 'teknisi'])->middleware('auth')->name('tugas.index');
Route::get('tugas/{id}', [TugasController::class, 'show'])->middleware('auth')->name('tugas.show');

Route::post('/tugas/{id}/ambil', [TugasController::class, 'takeTask'])->name('tugas.take');
Route::post('/tugas/{id}/end', [TugasController::class, 'endTask'])->name('tugas.end');

route::resource('progres', ProgresController::class)->middleware('auth');

Route::resource('laporan', LaporanController::class)
    ->except(['show', 'create'])
    ->middleware('auth');

Route::get('/laporan/selesai', [LaporanController::class, 'selesai'])
    ->name('laporan.selesai')
    ->middleware('auth');

Route::get('/laporan/penambahan', [LaporanController::class, 'penambahan'])
    ->name('laporan.penambahan')
    ->middleware('auth');

Route::get('/laporan/byTeknisi', [LaporanController::class, 'byTeknisi'])
    ->name('laporan.byTeknisi')
    ->middleware('auth');

Route::get('/laporan/create/{id}', [LaporanController::class, 'create'])
    ->name('laporan.create')
    ->middleware('auth');

Route::post('/laporan/{id}', [LaporanController::class, 'store'])
    ->name('laporan.store')
    ->middleware('auth');

// route untuk admin
Route::resource('user', UserController::class)->middleware('auth');

Route::get('tickets', [TicketsController::class, 'index'])->middleware('auth')->name('tickets.index');

Route::patch('/tickets/{id}/pay', [TicketsController::class, 'pay'])->name('tickets.pay');
Route::patch('/tickets/{id}/forward-to-technical', [TicketsController::class, 'forwardToTechnical'])->name('tickets.forwardToTechnical');

Route::resource('service', ServiceController::class)->middleware('auth');
Route::post('/service/{id}/cancel', [ServiceController::class, 'cancelPayment'])->name('service.cancel');
