<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\SystemsController;
use App\Http\Controllers\DashboardController;

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/home', function () {
    return view('home');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', function () {
        return redirect('/dashboard');
    });



    Route::get('/devices',[DevicesController::class,'index'])->name('devices');
    Route::get('/systems',[SystemsController::class,'index'])->name('systems');
    Route::get('/logs',[LogsController::class,'index'])->name('logs');
    

});
