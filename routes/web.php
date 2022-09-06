<?php

use App\Http\Controllers\PostListController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;


Route::get('', [PostListController::class, 'index']);

Route::get('posts/{post}', [PostListController::class, 'show'])->name('posts.show')->whereNumber('post');

Route::get('signup', [SignupController::class, 'index']);
Route::post('signup', [SignupController::class, 'store']);
