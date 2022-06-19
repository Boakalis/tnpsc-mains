<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Livewire\Course;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Evaluation;
use App\Http\Livewire\Evaluator;
use App\Http\Livewire\Exam;
use App\Http\Livewire\Test;
use Illuminate\Support\Facades\Route;

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


Auth::routes();
Route::get('/',function(){
    return view('home');
})->name('home');
Route::get('office-login',function(){
    return view('login');
})->name('login');

Route::post('office-login',[LoginController::class,'loginAttempt'])->name('attempt.login');

Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('exams',Exam::class)->name('exam');
    Route::get('courses',Course::class)->name('course');
    Route::get('tests',Test::class)->name('test');
    Route::get('evaluation',Evaluation::class)->name('evaluation');
    Route::get('evaluators',Evaluator::class)->name('evaluator');
});

Route::view('/{path?}', 'app');
