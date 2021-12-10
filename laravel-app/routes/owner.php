<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Owner\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Owner\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Owner\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Owner\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Owner\Auth\NewPasswordController;
use App\Http\Controllers\Owner\Auth\PasswordResetLinkController;
use App\Http\Controllers\Owner\Auth\RegisteredUserController;
use App\Http\Controllers\Owner\Auth\VerifyEmailController;
use App\Http\Controllers\Owner\ImageController;
use App\Http\Controllers\Owner\EmployeeController;

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

Route::get('/dashboard', function () {
	return view('owner.dashboard');
	// owners の権限をもっていたら表示される
})->middleware(['auth:owners'])->name('dashboard');

Route::resource('images', ImageController::class)
	->middleware(['auth:owners'])
	->except(['show']);

// Employee のルーティング
Route::resource('employees', EmployeeController::class)
	->middleware(['auth:owners'])
	->except(['show']);

// ソフトデリートしたデータ一覧の閲覧と完全削除用のルーティング
Route::prefix('expired-employees')
	->middleware('auth:owners')
	->group(function () {
		Route::get('index', [EmployeeController::class, 'expiredEmployeeIndex'])->name('expired-employees.index');
		Route::post('destroy/{employee}', [EmployeeController::class, 'expiredEmployeeDestroy'])->name('expired-employees.destroy');
	});

// 以下全て auth.php の内容を貼り付け
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
	->middleware('guest')
	->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
	->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
	->middleware('guest')
	->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
	->middleware('guest')
	->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
	->middleware('guest')
	->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
	->middleware('guest')
	->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
	->middleware('auth:owners')
	->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
	->middleware(['auth:owners', 'signed', 'throttle:6,1'])
	->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
	->middleware(['auth:owners', 'throttle:6,1'])
	->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
	->middleware('auth:owners')
	->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
	->middleware('auth:owners');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
	->middleware('auth:owners')
	->name('logout');
