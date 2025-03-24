<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use App\Http\Controllers\MikrotikApiController;

Route::prefix('mikrotik')->group(function () {
    Route::get('/interfaces', [MikrotikApiController::class, 'interfaces']);
    Route::get('/traffic/{interface}', [MikrotikApiController::class, 'traffic']);
    Route::get('/arp', [MikrotikApiController::class, 'arp']);
    Route::get('/dhcp-leases', [MikrotikApiController::class, 'dhcpLeases']);
    Route::get('/resource', [MikrotikApiController::class, 'resource']);
    Route::get('/logs', [MikrotikApiController::class, 'logs']);
    Route::get('/system-identity', [MikrotikApiController::class, 'systemIdentity']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
