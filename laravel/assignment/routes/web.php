<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\StudentController;

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

// Redirect to student list
Route::get('/', function () {
    return redirect()->route('students.index');
});

// Students list resource route
Route::resource('students', StudentController::class)->except('show');
Route::get('students/download', [StudentController::class, 'downloadCSV'])->name('students.download');
Route::get('students/upload', [StudentController::class, 'showUpload'])->name('students.upload');
Route::post('students/submit', [StudentController::class, 'submitUpload'])->name('students.submit');
