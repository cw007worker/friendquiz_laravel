<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\gameController;



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

Route::get('/', function () {
    return view('homepage');
});


Route::get('about-us', function () {
    return view('aboutUs');
});

Route::get('social', function () {
    return view('social');
});

Route::get('contact-us', function () {
    return view('contactUs');
});

Route::get('privacy-policy', function () {
    return view('privacyPolicy');
});

Route::get('terms-of-use', function () {
    return view('termsOfUse');
});

Route::get('faq', function () {
    return view('faq');
});

Route::get('feedback', function () {
    return view('feedback');
});

Route::any('start-game', [gameController::class, 'index']);

Route::post('create-game', [gameController::class, 'createQuiz']);

Route::get('share', [gameController::class, 'shareQuiz']);

Route::get('friends-board', [gameController::class, 'friendBoard']);

Route::get('dashboard', [gameController::class, 'dashboard']);

Route::get('playground', [gameController::class, 'retakeQuiz']);

Route::any('playground/start-game', [gameController::class, 'retakeQuizStart']);

Route::post('/playground/create-game', [gameController::class, 'retakeQuizCreate']);

Route::get('/playground/end-game', [gameController::class, 'retakeQuizEnd']);

Route::post('/playground/delete-game', [gameController::class, 'deleteQuiz']);