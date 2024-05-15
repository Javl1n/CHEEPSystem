<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\MessageController;

Route::permanentRedirect('/', 'posts');
Route::redirect('dashboard', 'posts');

Route::middleware(['auth', 'verified', 'user-verified', 'unrestricted'])->group(function() {
    // Student
    Route::middleware(['student'])->group(function () {
        Volt::route('student/evaluations', 'pages.student.evaluations.index')
            ->name('student.evaluations.index');

        Volt::route('student/evaluations/{teacher}', 'pages.student.evaluations.show')
            ->name('student.evaluations.show');
            
        Volt::route('student/polls', 'pages.student.polls.index')
            ->name('student.polls.index');
    }); 

    // Teacher
    Route::middleware(['teacher'])->group(function () {
        Volt::route('teacher/evaluations/', 'pages.teacher.evaluations.index')
            ->name('teacher.evaluations.index');
    }); 

    // Admin
    Route::middleware(['admin'])->group(function () {
        Volt::route('users', 'pages.admin.users.index')
            ->name('users.index');

        Volt::route('admin/evaluations', 'pages.admin.evaluations.index')
            ->name('admin.evaluations.index');

        Volt::route('admin/evaluations/{teacher}', 'pages.admin.evaluations.show')
            ->name('admin.evaluations.show');
        
        Volt::route('subjects', 'pages.admin.subjects.index')
            ->name('subjects.index');

        Volt::route('admin/polls/index', 'pages.admin.polls.index')
            ->name('admin.polls.index');
    });

    // Posts
    Volt::route('posts', 'pages.post.index')->name('posts.index');

    // Messages
    Volt::route('messages/{user}', 'pages.messages.show')->name('messages.show');
    Route::get('messages', [MessageController::class, 'index'])->name('messages.index');

    // Profile
    Route::view('profile', 'profile')->name('profile');
});


// Redirects
Route::view('unverified', 'unverified')
    ->middleware(['auth', 'user-unverified'])
    ->name('unverified');

Route::view('restricted', 'restricted')
    ->middleware(['auth', 'restricted'])
    ->name('restricted');



require __DIR__.'/auth.php';