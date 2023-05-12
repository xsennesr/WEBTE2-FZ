<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\ZipController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\LanguageManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HomeController;

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

Route::get('lang/home', [LangController::class, 'index'])->middleware('lang');

Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');
/*
|--------------------------------------------------------------------------
|                   Teacher Routes
|--------------------------------------------------------------------------
*/
Route::prefix('teacher')->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard')->middleware('lang');
    Route::get('/students', [TeacherController::class, 'studentsTable'])->name('teacher.studentsTable')->middleware('lang');
    Route::get('/student/{id}', [TeacherController::class, 'showStudent'])->name('teacher.show-student')->middleware('lang');
    Route::post('/upload', [ZipController::class, 'uploadFile'])->name('teacher.upload.zip')->middleware('lang');
    Route::get('/edit-batch/{batch_id}/edit-task/{task_id}', [TeacherController::class, 'editTask'])->name('teacher.edit-task')->middleware('lang');
    Route::put('/update-task/{id}', [TeacherController::class, 'updateTask'])->name('teacher.update-task')->middleware('lang');
    Route::get('/edit-batch/{id}', [TeacherController::class, 'editBatch'])->name('teacher.edit-batch')->middleware('lang');
    Route::put('/update-batch/{id}', [TeacherController::class, 'updateBatch'])->name('teacher.update-batch')->middleware('lang');
    Route::get('teacher/export-csv', [TeacherController::class, 'exportCsv'])->name('teacher.export-csv')->middleware('lang');
})->middleware('auth');
/*
|--------------------------------------------------------------------------
|                   Student Routes
|--------------------------------------------------------------------------
*/
Route::prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard')->middleware('lang');
    Route::post('/generate-task', [StudentController::class, 'generateTask'])->name('student.generate-task')->middleware('lang');
    Route::get('/render-task/{id}', [StudentController::class, 'renderTask'])->name('student.render-task')->middleware('lang');
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
