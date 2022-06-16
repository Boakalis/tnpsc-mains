<?php

use App\Http\Controllers\CourseApiController;
use App\Http\Controllers\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::get('get-question/{id}', [CourseApiController::class, 'getQuestion'])->name('question');
    Route::get('get-schedule/{id}', [CourseApiController::class, 'getSchedule'])->name('schedule');
    Route::post('submit-question', [CourseApiController::class, 'submitQuestion'])->name('submit');
    Route::get('profile', [UserApiController::class, 'profile'])->name('profile');
    Route::get('get-answer/{id}', [CourseApiController::class, 'getAnswer'])->name('getAnswer');
    Route::post('/change-password', [UserApiController::class, 'changePassword'])->name('changePassword');
    Route::post('/payment-status', [UserApiController::class, 'paymentStatus'])->name('paymentStatus');
    Route::post('/payment-success', [UserApiController::class, 'paymentSuccess'])->name('paymentSuccess');
    Route::post('log-out', [UserApiController::class, 'logOut'])->name('logOut');
    Route::post('orders', [UserApiController::class, 'orderInitiate'])->name('orderInitiate');
    Route::get('notifications', [UserApiController::class, 'notifications'])->name('notifications');
});


Route::post('login', [UserApiController::class, 'login'])->name('login');
Route::post('register', [UserApiController::class, 'register'])->name('register');
Route::get('get-exams', [CourseApiController::class, 'getExams'])->name('get.exams');
Route::get('get-plans/{slug}', [CourseApiController::class, 'getPlans'])->name('get.plans');
Route::get('get-courses/{plan}/{slug}', [CourseApiController::class, 'getCourse'])->name('get.courses');
