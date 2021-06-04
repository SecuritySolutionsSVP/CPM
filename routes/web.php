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

Route::post('/password', [CredentialController::class, "create"]);
    Route::put('/password', [CredentialController::class, "update"]);
    Route::delete('/password',[CredentialController::class, "delete"]);

Route::middleware(['auth'])->group(function() {
    Route::get('/usergroups', [UserGroupController::class, "allUsergroupsView"]);
    Route::get('/usergroups/{id}/passwords', [UserGroupController::class, "groupPasswordsView"])->whereNumber('id');
    Route::get('/user/{id}/passwords', [UserGroupController::class, "myPasswordsView"])->whereNumber('id');
    
    //Password
    Route::get('/', [CredentialController::class, "notificationPasswordsView"]);
    Route::get('/password', [CredentialController::class, "allPasswordsView"]);
    /*Route::post('/password', [CredentialController::class, "create"]);
    Route::put('/password', [CredentialController::class, "update"]);
    Route::delete('/password',[CredentialController::class, "delete"]);*/

    // Group
    Route::get('/groups', [GroupController::class, "groupsView"]);
    Route::post('/usergroups', [GroupController::class, "create"]);
    Route::put('/usergroups', [GroupController::class, "update"]);
    Route::delete('/usergroups',[GroupController::class, "delete"]);
    
    //User
    Route::get('/users', [UserController::class, "userView"]);
    Route::get('/user/{id}', [UserController::class, "profileView"])->whereNumber('id');
    Route::post('/user', [UserController::class, "create"]);
    Route::put('/user', [UserController::class, "update"]);
    Route::put('/user/password', [UserController::class, "updatePassword"]);
    Route::delete('/user',[UserController::class, "delete"]);
    Route::delete('/user/force',[UserController::class, "forceDelete"]);

    // Role
    Route::get('/roles', [RoleController::class, "rolesView"]);
    Route::post('/role/create', [RoleController::class, "create"]);
    Route::put('/role/update', [RoleController::class, "update"]);
    Route::delete('/role/delete',[RoleController::class, "delete"]);
    
    Route::get('/site-settings', [SiteController::class, 'siteSettingsView']);
    
    Route::get('/logs', [LogController::class, 'logView']);
});