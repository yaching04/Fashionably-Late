@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('title', 'ログイン')

@section('content')
    <div class="contact-page">

        <div class="contact-container">

            <div class="contact-header">
                <h1>Login</h1>
            </div>

            <form action="{{ route('login') }}" method="POST" class="contact-form" novalidate>
                @csrf

                <!-- メールアドレス -->
                <div class="form-group">
                    <label for="email">メールアドレス <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        placeholder="example@example.com">
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- パスワード -->
                <div class="form-group">
                    <label for="password">パスワード <span class="required">*</span></label>

                    <input type="password" id="password" name="password" placeholder="パスワード">
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 送信ボタン -->
                <div class="form-group submit-area">
                    <button type="submit" class="submit-button">
                        ログイン
                    </button>
                </div>

            </form>

        </div>
    </div>
@endsection
