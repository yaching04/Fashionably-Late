@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/contacts/index.css') }}">
@endsection

@section('title', 'お問い合わせ')

@section('content')
<div class="contact-page">

    <div class="contact-container">

        <div class="contact-header">
            <h1>Contact</h1>
        </div>


        <form action="{{ route('contacts.confirm') }}" method="POST" class="contact-form">
            @csrf

            <!-- 氏名（横並び） -->
            <div class="form-group">
                <label>氏名 <span class="required">※</span></label>
                <div class="name-fields">
                    <div class="name-input">
                        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="姓" class="{{ $errors->has('first_name') ? 'is-invalid' : '' }}">
                        @error('first_name')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="name-input">
                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="名" class="{{ $errors->has('last_name') ? 'is-invalid' : '' }}">
                        @error('last_name')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- 性別 -->
            <div class="form-group">
                <label>性別 <span class="required">※</span></label>

                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="gender" value="1" {{ old('gender') == '1' ? 'checked' : '' }}> 男性
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="gender" value="2" {{ old('gender') == '2' ? 'checked' : '' }}> 女性
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="gender" value="3" {{ old('gender') == '3' ? 'checked' : '' }}> その他
                    </label>
                    @error('gender')
                    <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- メールアドレス -->
            <div class="form-group">
                <label for="email">メールアドレス <span class="required">※</span></label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="example@example.com" class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                @error('email')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- 電話番号 -->
            <div class="form-group">
                <label>電話番号 <span class="required">※</span></label>
                <div class="tel-group">
                    <input type="text" name="tel1" value="{{ old('tel1') }}" maxlength="5" placeholder="090" class="{{ $errors->has('tel1') ? 'is-invalid' : '' }}">
                    <span class="tel-separator">-</span>
                    <input type="text" name="tel2" value="{{ old('tel2') }}" maxlength="5" placeholder="1234" class="{{ $errors->has('tel2') ? 'is-invalid' : '' }}">
                    <span class="tel-separator">-</span>
                    <input type="text" name="tel3" value="{{ old('tel3') }}" maxlength="5" placeholder="5678" class="{{ $errors->has('tel3') ? 'is-invalid' : '' }}">
                </div>
                @error('tel1')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- 住所 -->
            <div class="form-group">
                <label for="address">住所 <span class="required">※</span></label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" placeholder="市区町村まで" class="{{ $errors->has('address') ? 'is-invalid' : '' }}">
                @error('address')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- 建物名 -->
            <div class="form-group">
                <label for="building">建物名</label>
                @error('building')
                    <div class="field-error">{{ $message }}</div>
                @enderror
                <input type="text" id="building" name="building" value="{{ old('building') }}" placeholder="マンション名・部屋番号など">
            </div>

            <!-- お問い合わせ種別 -->
            <div class="form-group">
                <label for="category_id">お問い合わせ種別 <span class="required">※</span></label>
                <select id="category_id" name="category_id" class="{{ $errors->has('category_id') ? 'is-invalid' : '' }}">
                    <option value="" hidden>選択してください</option>
                    @foreach ($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->content }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- お問い合わせ内容 -->
            <div class="form-group">
                <label for="detail">お問い合わせ内容 <span class="required">※</span></label>
                <textarea id="detail" name="detail" rows="8" placeholder="お問い合わせ内容をご記入ください" class="{{ $errors->has('detail') ? 'is-invalid' : '' }}">{{ old('detail') }}</textarea>
                @error('detail')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- 送信ボタン -->
            <div class="form-group submit-area">
                <button type="submit" class="submit-button">
                    確認画面へ
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
