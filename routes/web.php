<?php

use App\Http\Controllers\LangController;
use App\Http\Controllers\ZipController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
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
    return view('index');
})->name('index');


Route::get('lang/home', [LangController::class, 'index'])->middleware(LanguageManager::class);

Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');
/*
|--------------------------------------------------------------------------
|                   Teacher Routes
|--------------------------------------------------------------------------
*/
Route::prefix('teacher')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::post('/upload', [ZipController::class, 'uploadFile'])->name('teacher.upload.zip');
    Route::get('/edit-batch/{batch_id}/edit-task/{task_id}', [TeacherController::class, 'editTask'])->name('teacher.edit-task');
    Route::put('/update-task/{id}', [TeacherController::class, 'updateTask'])->name('teacher.update-task');
    Route::get('/edit-batch/{id}', [TeacherController::class, 'editBatch'])->name('teacher.edit-batch');
    Route::put('/update-batch/{id}', [TeacherController::class, 'updateBatch'])->name('teacher.update-batch');
});
/*
|--------------------------------------------------------------------------
|                   Student Routes
|--------------------------------------------------------------------------
*/
Route::prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
});
