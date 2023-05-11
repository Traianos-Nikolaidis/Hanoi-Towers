<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CanvasController;
use App\Http\Controllers\UserQuizController;
use App\Http\Controllers\ProfessorQuizController;
use App\Http\Controllers\ChangePasswordController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


Auth::routes(['verify' => true]);

Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/welcome');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/welcome', function () {
    return view('welcome');
})->middleware(['auth', 'verified']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth', 'superadmin', 'admin']], function () {
    Route::resource('users', 'App\Http\Controllers\UserController', ['except' => ['create', 'store', 'show']]);
    Route::get('stats', [StatController::class, 'index'])->name('stats.index');
    Route::get('stats/user/{user}', [StatController::class, 'userQuizzes'])->name('stats.user-quizzes');
    Route::get('stats/user/{user}/quiz/{quiz}', [StatController::class, 'userQuizStats'])->name('stats.user-quiz-stats');
});
Route::group(['middleware' => ['auth', 'notStudent']], function () {
    Route::get('quiz/create', [QuizController::class, 'create'])->name('quiz.create');
    Route::post('quiz', [QuizController::class, 'store'])->name('quiz.store');
});
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index')->middleware(['auth', 'verified']);
Route::get('quiz/averages', [QuizController::class, 'averages'])->name('quiz.averages');
Route::get('users/averages', [UserController::class, 'averages'])->name('users.averages');

Route::get('my-stats', [UserQuizController::class, 'myStats'])->middleware('auth')->name('my-stats');
Route::get('professor/quizzes/stats', [ProfessorQuizController::class, 'stats'])->middleware('auth')->name('professor.quizzes.stats');
Route::get('professor/quizzes/{quiz}/stats', [ProfessorQuizController::class, 'quizStats'])->middleware('auth')->name('professor.quizzes.userstats');
Route::post('clear-stats', [UserQuizController::class, 'clearStats'])->middleware('auth')->name('clear-stats');
Route::get('/canvas', [CanvasController::class, 'index'])->name('canvas');

Route::get('play/{quiz}', [UserQuizController::class, 'play'])->middleware('auth')->name('play');
Route::post('play', [UserQuizController::class, 'submit'])->middleware('auth')->name('submit');
Route::post('/submit-game-stats', [StatsController::class, 'store'])->name('submit.game.stats');
Route::get('change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('change-password.form');
Route::post('change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');