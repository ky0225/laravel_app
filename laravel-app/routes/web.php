<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ListController;

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

//Route::get('/', function () {
//	return view('user.index');
//})->middleware('auth:users')->name('index');

Route::middleware('auth:users')
	->get('/index', [ListController::class, 'index'])
	->name('index');

Route::get('/dashboard', function () {
	return view('user.dashboard');
})->middleware(['auth:users'])->name('dashboard');

require __DIR__ . '/auth.php';
