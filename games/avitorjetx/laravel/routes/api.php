<?php

use App\Http\Controllers\BridgeTokenProbeController;
use App\Http\Controllers\Userdetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** Bridge JWT check (only if APP_DEBUG or BRIDGE_TOKEN_PROBE_ENABLED). */
Route::get('/bridge-token/verify', BridgeTokenProbeController::class);
Route::post('/bridge-token/verify', BridgeTokenProbeController::class);

//Data api
Route::post('/user/withdrawal_list', [Userdetail::class,"withdrawal_list"]);
