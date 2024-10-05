<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\AuthController;

//para forçar estar logado add ->middleware('auth');, exemplo abaixo
Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::get('/', function () {
    return view('home');
});

Route::resource('characters', CharacterController::class);


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


