<style>
/* モーダル内詳細画面用CSS（強制適用） */
.detail-content {
    margin-bottom: 20px;
    max-width: 600px;
    align-items: center;
    margin: 0 auto;
}

.detail-row {
    display: flex;
    gap: 25px;
    padding: 18px 0;
    border-bottom: 1px solid #f0f0f0;
    align-items: flex-start;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    width: 160px;
    flex-shrink: 0;
    font-weight: 600;
    color: #555;
}

.detail-value {
    flex: 1;
    color: #333;
    line-height: 1.65;
}

.detail-text {
    word-break: break-all;
    background-color: #f9f9f9;
    padding: 18px;
    border-radius: 8px;
    border-left: 5px solid #a78888;
}
</style>

<div class="detail-content">
    <div class="detail-row">
        <div class="detail-label">お名前</div>
        <div class="detail-value">{{ $contact->first_name }} {{ $contact->last_name }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">性別</div>
        <div class="detail-value">
            {{ match($contact->gender) { 1 => '男性', 2 => '女性', 3 => 'その他', default => '不明' } }}
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">メールアドレス</div>
        <div class="detail-value">{{ $contact->email }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">電話番号</div>
        <div class="detail-value">{{ $contact->tel }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">住所</div>
        <div class="detail-value">{{ $contact->address }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">建物名</div>
        <div class="detail-value">{{ $contact->building ?? 'なし' }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">お問い合わせ種別</div>
        <div class="detail-value">{{ $contact->category->content ?? '未分類' }}</div>
    </div>

    <div class="detail-row">
        <div class="detail-label">お問い合わせ内容</div>
        <div class="detail-value detail-text">
            {{ $contact->detail }}
        </div>
    </div>
</div>
