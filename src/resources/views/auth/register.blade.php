@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('title', '会員登録')

@section('content')
<div class="contact-page">

    <div class="contact-container">

        <div class="contact-header">
            <h1>Register</h1>
        </div>

        {{-- エラーメッセージ --}}
        @if ($errors->any())
            <div class="error-messages">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="contact-form">
            @csrf

            <!-- お名前 -->
            <div class="form-group">
                <label for="name">お名前 <span class="required">*</span></label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="山田 太郎"
                    required
                >
            </div>

            <!-- メールアドレス -->
            <div class="form-group">
                <label for="email">メールアドレス <span class="required">*</span></label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="example@example.com"
                    required
                >
            </div>

            <!-- パスワード -->
            <div class="form-group">
                <label for="password">パスワード <span class="required">*</span></label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="パスワード（8文字以上）"
                    required
                >
            </div>

            <!-- 登録ボタン -->
            <div class="form-group submit-area">
                <button type="submit" class="submit-button">
                    登録
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
