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
    Route::get('/interfaces', [MikrotikApiController::class, 'interfaces'])->name('api.interfaces');
    Route::get('/traffic/{interface}', [MikrotikApiController::class, 'traffic'])->name('api.traffic');
    Route::get('/arp', [MikrotikApiController::class, 'arp'])->name('api.arp');
    Route::get('/dhcp-leases', [MikrotikApiController::class, 'dhcpLeases'])->name('api.dhcp-leases');
    Route::get('/resource', [MikrotikApiController::class, 'resource'])->name('api.resource');
    Route::get('/logs', [MikrotikApiController::class, 'logs'])->name('api.logs');
    Route::get('/system-identity', [MikrotikApiController::class, 'systemIdentity'])->name('api.system-identity');
    Route::get('/traffic-history', [MikrotikApiController::class, 'trafficHistory']);
    Route::get('/bandwidth-history', [MikrotikApiController::class, 'bandwidthHistory']);
    Route::get('/', [MikrotikApiController::class, 'testConnection'])->name('api.test');
    Route::get('/test-env', [MikrotikApiController::class, 'testEnv']);
    Route::get('/latency', [MikrotikApiController::class, 'latency']);
    Route::get('/uptime', [MikrotikApiController::class, 'uptime']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
