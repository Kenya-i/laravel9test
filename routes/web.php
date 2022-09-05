<?php

use App\Http\Controllers\PostListController;
use Illuminate\Support\Facades\Route;


Route::get('', [PostListController::class, 'index']);

Route::get('posts/{post}', [PostListController::class, 'show'])->name('posts.show')->whereNumber('post');
