<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, "loginView"]);

Route::get('/usergroups', [UserGroupController::class, "allUsergroupsView"]);
Route::get('/usergroups/{id}/passwords', [UserGroupController::class, "groupPasswordsView"]);
Route::get('/user/{id}/passwords', [UserGroupController::class, "myPasswordsView"]);

Route::get('/', [PasswordController::class, "notificationPasswordsView"]);