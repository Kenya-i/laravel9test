<?php

use App\Http\Controllers\Mypage\PostManageController;
use App\Http\Controllers\Mypage\UserLoginController;
use App\Http\Controllers\PostListController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;


Route::get('', [PostListController::class, 'index'])->name('postlist.index');

Route::get('posts/{post}', [PostListController::class, 'show'])->name('posts.show')->whereNumber('post');

Route::get('signup', [SignupController::class, 'index']);
Route::post('signup', [SignupController::class, 'store']);


Route::get('mypage/login', [UserLoginController::class, 'index'])->name('login');

Route::post('mypage/login', [UserLoginController::class, 'login']);

Route::middleware('auth')->group(function () {
  Route::get('mypage/posts', [PostManageController::class, 'index']);
});

