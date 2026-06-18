@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/contacts/confirm.css') }}">
@endsection

@section('title', 'お問い合わせ確認')

@section('content')
<div class="contact-page">

    <div class="contact-container">

        <div class="contact-header">
            <h1>Confirm</h1>
        </div>

        <div class="confirm-content">

            <div class="confirm-row">
                <div class="confirm-label">お名前</div>
                <div class="confirm-value">{{ $validated['first_name'] ?? '' }} {{ $validated['last_name'] ?? '' }}</div>
            </div>

            <div class="confirm-row">
                <div class="confirm-label">性別</div>
                <div class="confirm-value">
                    @php
                        $genderLabel = match((int)($validated['gender'] ?? 0)) {
                            1 => '男性',
                            2 => '女性',
                            3 => 'その他',
                            default => '不明',
                        };
                    @endphp
                    {{ $genderLabel }}
                </div>
            </div>

            <div class="confirm-row">
                <div class="confirm-label">メールアドレス</div>
                <div class="confirm-value">{{ $validated['email'] ?? '' }}</div>
            </div>

            <div class="confirm-row">
                <div class="confirm-label">電話番号</div>
                <div class="confirm-value">
                    {{ $validated['tel1'] ?? '' }}-{{ $validated['tel2'] ?? '' }}-{{ $validated['tel3'] ?? '' }}
                </div>
            </div>

            <div class="confirm-row">
                <div class="confirm-label">住所</div>
                <div class="confirm-value">{{ $validated['address'] ?? '' }}</div>
            </div>

            <div class="confirm-row">
                <div class="confirm-label">建物名</div>
                <div class="confirm-value">{{ $validated['building'] ?? 'なし' }}</div>
            </div>

            <div class="confirm-row">
                <div class="confirm-label">お問い合わせ種別</div>
                <div class="confirm-value">{{ $category->content ?? '未選択' }}</div>
            </div>

            <div class="confirm-row">
                <div class="confirm-label">お問い合わせ内容</div>
                <div class="confirm-value confirm-detail">
                    {!! nl2br(e(trim($validated['detail'] ?? ''))) !!}
                </div>
            </div>
        </div>

        <div class="confirm-buttons">

            <!-- 送信する -->
            <form action="{{ route('contacts.store') }}" method="POST" style="display: inline;">
                @csrf
                @foreach($validated ?? [] as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <button type="submit" class="btn btn-primary">送信</button>
            </form>

                        <!-- 修正する -->
            <form action="{{ route('contacts.edit') }}" method="POST" style="display: inline;">
                @csrf
                @foreach($validated ?? [] as $key => $value)
                    @if(!is_null($value))
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <div class="button">
                    <button type="submit" class="btn btn-secondary">修正</button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
