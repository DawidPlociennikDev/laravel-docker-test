<?php

use App\Http\Controllers\SmsController;
use App\Http\Controllers\WelcomeController;
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
    return view('welcome');
});

Route::get('/test', [WelcomeController::class, 'index']);
Route::get('/sms', [SmsController::class, 'sms']);
Route::post('/sms', [SmsController::class, 'sms']);
