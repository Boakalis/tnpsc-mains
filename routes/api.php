<?php

use App\Http\Controllers\CourseApiController;
use App\Http\Controllers\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
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
    Route::post('profile-update', [UserApiController::class, 'profileUpdate'])->name('profileUpdate');
    Route::get('get-answer/{id}', [CourseApiController::class, 'getAnswer'])->name('getAnswer');
    Route::get('get-courses', [UserApiController::class, 'getCourse'])->name('getCourse');
    Route::get('get-reports', [UserApiController::class, 'getReports'])->name('getReports');
    Route::post('/change-password', [UserApiController::class, 'changePassword'])->name('changePassword');
    Route::post('/payment-status', [UserApiController::class, 'paymentStatus'])->name('paymentStatus');
    Route::post('/payment-success', [UserApiController::class, 'paymentSuccess'])->name('paymentSuccess');
    Route::post('log-out', [UserApiController::class, 'logOut'])->name('logOut');
    Route::post('orders', [UserApiController::class, 'orderInitiate'])->name('orderInitiate');
    Route::get('notifications', [UserApiController::class, 'notifications'])->name('notifications');
    Route::get('clear-notifications', [UserApiController::class, 'clearNotifications'])->name('clear.notifications');
    Route::get('analytics-data', [UserApiController::class, 'analytics'])->name('analytics');
    Route::get('auth', [UserApiController::class, 'auth'])->name('auth');
});


Route::post('check-mail', [UserApiController::class, 'checkMail'])->name('checkMail');
Route::post('check-otp', [UserApiController::class, 'checkOtp'])->name('checkOtp');
Route::post('login', [UserApiController::class, 'login'])->name('login');
Route::post('google-login', [UserApiController::class, 'googleLogin'])->name('google.login');
Route::post('register', [UserApiController::class, 'register'])->name('register');
Route::get('get-exams', [CourseApiController::class, 'getExams'])->name('get.exams');
Route::get('get-plans/{slug}', [CourseApiController::class, 'getPlans'])->name('get.plans');
Route::get('get-courses/{plan}/{slug}', [CourseApiController::class, 'getCourse'])->name('get.courses');
Route::post('api-to-get-motivation-and-save-in-db', [UserApiController::class, 'motivationQuotes'])->name('motivationQuotes');
Route::get('/google-s',function(){
    $access_token = Socialite::driver('google')->getAccessTokenResponse($token);
    $user = Socialite::driver('google')->userFromToken('eyJhbGciOiJSUzI1NiIsImtpZCI6IjI2NTBhMmNlNDdiMWFiM2JhNDA5OTc5N2Y4YzA2ZWJjM2RlOTI4YWMiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJuYmYiOjE2NTY4MjcxMjYsImF1ZCI6IjY3MTU5OTA0MTE3OC1wZW9uaHV2cjdybzNjYjhudWdxODRnYnU0bWJqMDVzdS5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsInN1YiI6IjExNTkwOTE0OTE4OTU4MzY1MDY1NSIsImVtYWlsIjoiY29xYWNjMTVAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImF6cCI6IjY3MTU5OTA0MTE3OC1wZW9uaHV2cjdybzNjYjhudWdxODRnYnU0bWJqMDVzdS5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsIm5hbWUiOiJCb29wYXRoeSIsInBpY3R1cmUiOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vYS0vQU9oMTRHZ18xNC1ONVZ4a1BzNU5qeFpCV2NUTWtmVVRjaEVzN1RFUExTdWdPdz1zOTYtYyIsImdpdmVuX25hbWUiOiJCb29wYXRoeSIsImlhdCI6MTY1NjgyNzQyNiwiZXhwIjoxNjU2ODMxMDI2LCJqdGkiOiJhNDU2YTg3YjRlMTMwM2QwNDUzODJiM2QwODQzYWI2MWYwNTQ5MTE3In0.HVXQyAX8JWLhbyeN16gCUxS59EttZHPvgGJVPzalbUjdDusn9rEJ88JiJD9gvrR2-_GOcM2nEm_RMMGrQG-j2bfN9h7z7sPnw4tOX7OvN5HB852_XRXQrJu7fyRrtE78RSVxXU2A5geheSQ7MzI1TE6xxnkRjCdC3uFis2iHpFcjTinQ0_RB_xRBUMfmPVSeOGb-VAHowvyn6GBg-NfmPgpE_E1pb92EULSkMWjGCWsuaKFLj6QdRylehA23abBx1AGNmzEf6lwY5mefjF4tKq4OHAluG9359LzdMc06Ayvq2UWb-H2YTmSvxVLOi-Mxz6_NGthtPAtBYNjaqUnoNA');
});
