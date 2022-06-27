<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HelperController;
use App\Http\Livewire\ChangePassword;
use App\Http\Livewire\Course;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Enquiry as LivewireEnquiry;
use App\Http\Livewire\Evaluation;
use App\Http\Livewire\Evaluator;
use App\Http\Livewire\Exam;
use App\Http\Livewire\OrderList;
use App\Http\Livewire\Test;
use App\Http\Livewire\UserList;
use App\Mail\PasswordRecoveryMail;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Mail;
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
// Route::get('send-mail', function () {

//     try {

//         $details = [
//             'otp' => '123456',
//         ];

//         \Mail::to('coqacc102@gmail.com')->send(new PasswordRecoveryMail($details));

//         dd("Email is Sent.");
//     } catch (\Throwable $th) {
//         dd($th->getMessage());
//     }
// });

Auth::routes();
Route::get('/',function(){
    return view('home');
})->name('home');
Route::get('/contact-us',function(){
    return view('contact');
})->name('contact');
Route::get('/about-us',function(){
    return view('about-us');
})->name('about');
Route::get('/privacy-policy',function(){
    return view('privacy-policy');
})->name('privacy');
Route::get('/password',function(){
    return view('emails.password');
})->name('password');

Route::get('/terms-and-condition',function(){
    return view('terms-and-conditions');
})->name('terms-condition');
Route::get('office-login',function(){
    return view('login');
})->name('login');
Route::post('contact-submit',[HomeController::class,'contactSubmit'])->name('contact.submit');
Route::get('adfasfasdfbasc8yrhisfoasidyfsbnify87trabrcoashga8txf78eiuen78zt78b87t7a8xfn7aet7f8tvba78vtce4toiua98tye8973rxctnw897',function() {
    Artisan::call('storage:link');
});

Route::post('office-login',[LoginController::class,'loginAttempt'])->name('attempt.login');

Route::prefix('admin')->group(function () {

    Route::middleware(['admin'])->group(function () {
        Route::get('exams',Exam::class)->name('exam');
        Route::get('courses',Course::class)->name('course');
        Route::get('evaluators',Evaluator::class)->name('evaluator');
        Route::get('orders',OrderList::class)->name('orders');
        Route::get('users',UserList::class)->name('users');
        Route::get('enquiries',LivewireEnquiry::class)->name('enquiry');
        Route::get('settings',[HomeController::class,'settings'])->name('settings');
        Route::post('settings',[HomeController::class,'submitSettings'])->name('settings.post');
        Route::post('/fileUploadEditor', [HelperController::class, 'fileUploadEditor'])
        ->name('fileUploadEditor');
    });
    Route::middleware(['evaluator'])->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/change-password', ChangePassword::class)->name('change.password');
        Route::get('tests',Test::class)->name('test');
        Route::get('evaluation',Evaluation::class)->name('evaluation');
        Route::get('logout',function() {
            Auth::logout();
            return redirect()->route('attempt.login');
        })->name('custom-logout');
    });

});


// Route::view('/{path?}', 'app')->where('path', '([A-z\d\-\/_.]+)?');
Route::view('/{path?}', 'app')->where('path', '.+');

