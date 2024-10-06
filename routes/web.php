<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\InventoryController;

//para forçar estar logado add ->middleware('auth');, exemplo abaixo
Route::get('/home', function () {
    return view('home');
})->middleware('auth')->name('home');

Route::get('/', function () {
    return view('home');
});

Route::resource('characters', CharacterController::class);
Route::resource('skills', SkillController::class);
Route::resource('items', ItemController::class);

Route::post('/inventory/{inventory}/add', [InventoryController::class, 'addItem'])->name('inventory.add');
Route::delete('/inventory/{character}/item/{item}', [InventoryController::class, 'removeItemFromInventory'])->name('inventory.remove');



Route::post('/characters/{character}/skills/add', [SkillController::class, 'addSkill'])->name('skills.add');
Route::delete('/characters/{character}/skills/{skill}/remove', [SkillController::class, 'removeSkill'])->name('skills.remove');





Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


