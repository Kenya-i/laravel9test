<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        if(Auth::attempt($credential)) {
            $request->session()->regenerate();

            return redirect()->intended('mypage/posts');
        }

        return back()->withErrors([
            'email' => 'メールアドレスまたはパスワードが間違っています。'
        ])->withInput();
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('login'))->with('status', 'ログアウトしました');
    }
}
