<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUser;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\SessionsUserController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Route principale vers la page d'accueil
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

// Route pour le filtrage des utilisateurs
Route::get('/levelup', [FilterController::class, 'index'])->name('levelup.index');
Route::get('/levelup/filter', [FilterController::class, 'filter'])->name('levelup.filter');

Route::get('/user/profile', [  UserProfileController::class, 'showProfile'])->name('user.profile.show');

require __DIR__.'/auth.php';

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

Route::post('/profile/photo/update', [ProfileController::class, 'updateProfilePhoto'])->name('profile.photo.update');

Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');

Route::post('/sessions/reserve', [SessionsUserController::class, 'reserve'])->name('sessions.reserve');

Route::post('/reservations', [SessionsUserController::class, 'store'])->name('reservations.store');

Route::get('/index', function () {
    return view('levelup.index');  
})->name('index.levelup');

Route::get('/home', function () {
    return view('home');
});
