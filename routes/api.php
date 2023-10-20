<?php

use App\Http\Controllers\{authController, FcmtokenController, PlayercateguryController, PlayerController, SoldplayerController, TeamController, userController};
use App\Models\fcmtoken;
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
// auth routes
Route::post('auth/login',[authController::class,'login']);
Route::post('token',[FcmtokenController::class,'store']);

Route::apiResource('team',TeamController::class);
Route::apiResource('playearcategury',PlayercateguryController::class);
Route::apiResource('player',PlayerController::class);
Route::apiResource('user',userController::class);
Route::get('soldplayer',[SoldplayerController::class,'index']);
Route::post('soldplayer',[SoldplayerController::class,'soldPlayer']);
Route::delete('soldplayer/{id}',[SoldplayerController::class,'destroy']);
