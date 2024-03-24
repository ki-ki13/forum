<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GroupController;
use App\Http\Controllers\API\PasswordChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// User
Route::apiResource('user', 'App\Http\Controllers\API\UserController');
Route::post('auth/checkLogin', [AuthController::class, 'checkLogin']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::put('changepassword', [PasswordChange::class, 'updatePassword']);
Route::put('user-group', [UserController::class, 'updateGroupId']);
// Group
Route::apiResource('group', 'App\Http\Controllers\API\GroupController');
Route::get('group/{group}/member', [GroupController::class, 'getGroupMember']);
Route::get('group-aktif', [GroupController::class, 'getAktifGroup']);

