<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('/users', App\Http\Controllers\UserController::class)->except('create', 'store', 'edit');
Route::resource('/roles', App\Http\Controllers\RoleController::class)->except('create', 'show', 'edit');
Route::resource('/sessions', App\Http\Controllers\SessionController::class)->except('create', 'edit');
