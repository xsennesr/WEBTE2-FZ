<?php

use App\Http\Controllers\ProfileController;
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
})->name('index')->middleware('auth');


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
})->middleware('auth');
/*
|--------------------------------------------------------------------------
|                   Student Routes
|--------------------------------------------------------------------------
*/
Route::prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::post('/generate-task', [StudentController::class, 'generateTask'])->name('student.generate-task');
    Route::get('/render-task/{id}', [StudentController::class, 'renderTask'])->name('student.render-task');
    Route::post('/submit-task/', [StudentController::class, 'submitTask'])->name('student.submit-task');
})->middleware('auth');
/*
|--------------------------------------------------------------------------
|                   Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
