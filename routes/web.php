<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CredentialController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
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
| contains the 'web' middleware group. Now create something great!
|
*/


Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function() {
    // User
    Route::get('/users', [UserController::class, "userView"])->middleware('role:Administrator,Manager');
    Route::get('/profile', [UserController::class, "profileView"])->whereNumber('id');
    Route::get('/user/{id}/credentials', [UserController::class, "userCredentialsView"])
        ->middleware('role:Administrator,Manager')->whereNumber('id');

    // Credentials
    Route::get('/', [CredentialController::class, "notificationCredentialsView"]);
    Route::get('/credentials', [CredentialController::class, "allCredentialsView"]);

    // Group
    Route::get('/groups', [GroupController::class, "groupsView"]);
    Route::get('/group/{id}/users', [GroupController::class, "groupUsersView"])
        ->middleware('role:Administrator,Manager')->whereNumber('id');
    Route::get('/group/{id}/credentials', [GroupController::class, "groupCredentialsView"])
        ->middleware('role:Administrator,Manager')->whereNumber('id');
});