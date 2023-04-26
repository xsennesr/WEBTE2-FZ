<?php

use App\Http\Controllers\LangController;
use App\Http\Middleware\LanguageManager;
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

Route::get('lang/home', [LangController::class, 'index'])->middleware(LanguageManager::class);

Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');