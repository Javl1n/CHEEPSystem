<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\MessageController;

Route::permanentRedirect('/', 'posts');



Volt::route('posts', 'pages.post.index')
    ->middleware(['auth', 'verified', 'user-verified'])
    ->name('posts.index');

Route::middleware(['auth', 'verified', 'student'])->group(function () {
    Volt::route('student/evaluations', 'pages.student.evaluations.index')
        ->name('student.evaluations.index');

    Volt::route('student/evaluations/{teacher}', 'pages.student.evaluations.show')
        ->name('student.evaluations.show');
}); 


Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('teacher/evaluations/', 'pages.teacher.evaluations.index')
        ->name('teacher.evaluations.index');
}); 

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Volt::route('users', 'pages.admin.users.index')
        ->name('users.index');

    Volt::route('admin/evaluations', 'pages.admin.evaluations.index')
        ->name('admin.evaluations.index');

    Volt::route('admin/evaluations/{teacher}', 'pages.admin.evaluations.show')
        ->name('admin.evaluations.show');

    Route::view('dashboard', 'dashboard')
        ->name('dashboard');
    
    Volt::route('subjects', 'pages.admin.subjects.index')
        ->name('subjects.index');
});

Volt::route('messages/{user}', 'pages.messages.show')
    ->middleware(['auth', 'verified', 'user-verified'])
    ->name('messages.show');

Route::get('messages', [MessageController::class, 'index'])
    ->middleware(['auth', 'verified', 'user-verified'])
    ->name('messages.index');

Route::view('unverified', 'unverified')
    ->middleware(['auth', 'user-unverified'])
    ->name('unverified');

Route::view('profile', 'profile')
    ->middleware(['auth', 'verified'])
    ->name('profile');

require __DIR__.'/auth.php';