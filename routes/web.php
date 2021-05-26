<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\LogController;
use GuzzleHttp\Middleware;
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


Route::get('/login', [AuthController::class, "loginView"])->name("login");

// Route::middleware(['auth'])->group(function() {
    Route::get('/usergroups', [UserGroupController::class, "allUsergroupsView"]);
    Route::get('/usergroups/{id}/passwords', [UserGroupController::class, "groupPasswordsView"]);
    Route::get('/user/{id}/passwords', [UserGroupController::class, "myPasswordsView"]);
    
    Route::get('/', [PasswordController::class, "notificationPasswordsView"])->middleware('auth');
    Route::get('/password', [PasswordController::class, "allPasswordsView"]);
    
    Route::get('/users', [UserController::class, "userView"]);
    Route::get('/user/{id}', [UserController::class, "profileView"]);
    
    Route::get('/site-settings', [SiteController::class, "siteSettingsView"]);
    
    Route::get('/logs', [LogController::class, "logView"]);
// });