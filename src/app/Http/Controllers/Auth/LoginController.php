<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => '・メールアドレスを入力してください',
            'email.email' => '・メールアドレスはメール形式で入力してください',
            'password.required' => '・パスワードを入力してください',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'password' => '・ログイン情報が登録されていません',
        ]);
    }
}
