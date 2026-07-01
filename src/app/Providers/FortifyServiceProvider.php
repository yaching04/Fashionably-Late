<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FortifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        // 言語設定を強制
        app()->setLocale('ja');

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        // カスタム認証ロジック
        Fortify::authenticateUsing(function ($request) {
            // バリデーション
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ], [
                'email.required' => '・メールアドレスを入力してください',
                'email.email' => '・メールアドレスはメール形式で入力してください',
                'password.required' => '・パスワードを入力してください',
            ], [
                'email' => 'メールアドレス',
                'password' => 'パスワード',
            ]);

            if ($validator->fails()) {
                $request->session()->flash('_old_input', $request->input());
                throw new \Illuminate\Validation\ValidationException($validator);
            }

            // 認証
            if (Auth::attempt($request->only('email', 'password'))) {
                return Auth::user();
            }

            // 認証失敗時
            throw \Illuminate\Validation\ValidationException::withMessages([
                'password' => '・ログイン情報が登録されていません',
            ]);
        });
    }
}
