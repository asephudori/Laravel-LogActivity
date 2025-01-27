<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\ActivityLogController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');

Route::resource('/mahasiswa', MahasiswaController::class);