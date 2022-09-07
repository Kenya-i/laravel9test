<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserLoginController extends Controller
{
    public function index() {
        return view('mypage.login');
    }

    public function login(Request $request) {
        $credential = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(\Auth::attempt($credential)) {
            $request->session()->regenerate();

            return redirect()->intended('mypage/posts');
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが間違っています。'
        ])->withInput();
    }
}
