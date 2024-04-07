<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::permanentRedirect('/', 'posts');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('dashboard');

Volt::route('posts', 'pages.post.index')
    ->middleware(['auth', 'verified', 'user-verified'])
    ->name('posts.index');

Route::view('unverified', 'unverified')->name('unverified');

Route::view('profile', 'profile')
    ->middleware(['auth', 'verified'])
    ->name('profile');

require __DIR__.'/auth.php';