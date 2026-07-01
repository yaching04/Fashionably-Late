@extends('layouts.app')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('title', '管理画面')

@section('content')
    <div class="admin-page">
        <div class="admin-container">

            <div class="admin-header">
                <h1>Admin</h1>
            </div>

            {{-- 検索フォーム --}}
            <div class="search-area">
                <form action="{{ route('admin.search') }}" method="GET" class="search-form">
                    <div class="search-row">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="名前またはメールアドレスを入力してください" class="search-input">

                        <select name="gender" class="search-select">
                            <option value="" hidden class="search-select-option">性別</option>
                            <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                            <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                            <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
                        </select>

                        <select name="category_id" class="search-select">
                            <option value="" hidden class="search-select-option">お問い合わせ種別</option>
                            @foreach ($categories ?? [] as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->content }}
                                </option>
                            @endforeach
                        </select>

                        <input type="date" name="date_from" value="{{ request('date_from') }}" class="search-date">

                        <button type="submit" class="btn btn-search">検索</button>
                        <a href="{{ route('admin.reset') }}" class="btn btn-reset">リセット</a>
                    </div>
                </form>
            </div>

            {{-- 成功メッセージ --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- エクスポート + ページネーション --}}
            <div class="toolbar">
                <a href="{{ route('admin.export') }}" class="btn btn-export">エクスポート</a>

                <div class="pagination">
                    @if ($contacts->hasPages())
                        <ul>
                            <!-- 前へ -->
                            @if ($contacts->onFirstPage())
                                <li class="disabled"><span>‹</span></li>
                            @else
                                <li><a href="{{ $contacts->previousPageUrl() }}">‹</a></li>
                            @endif

                            <!-- ページ番号 -->
                            @php
                                $start = max(1, $contacts->currentPage() - 2);
                                $end = min($contacts->lastPage(), $contacts->currentPage() + 2);
                            @endphp

                            @for ($page = $start; $page <= $end; $page++)
                                @if ($page == $contacts->currentPage())
                                    <li class="active"><span>{{ $page }}</span></li>
                                @else
                                    <li><a href="{{ $contacts->url($page) }}"> {{ $page }} </a></li>
                                @endif
                            @endfor

                            <!-- 次へ -->
                            @if ($contacts->hasMorePages())
                                <li><a href="{{ $contacts->nextPageUrl() }}">›</a></li>
                            @else
                                <li class="disabled"><span>›</span></li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>

            {{-- テーブル --}}
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>お名前</th>
                        <th>性別</th>
                        <th>メールアドレス</th>
                        <th>お問い合わせの種類</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr>
                            <td>{{ $contact->first_name }} {{ $contact->last_name }}</td>
                            <td>
                                @php
                                    $genderLabel = match ($contact->gender) {
                                        1 => '男性',
                                        2 => '女性',
                                        3 => 'その他',
                                        default => '不明',
                                    };
                                @endphp
                                {{ $genderLabel }}
                            </td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->category->content ?? '未分類' }}</td>
                            <td>
                                <a href="javascript:void(0);" onclick="openModal({{ $contact->id }})"
                                    class="btn btn-detail">詳細</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px;">該当するお問い合わせはありません</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    <!-- モーダル -->
    <div id="contactModal" class="modal" style="display: none;">
        <div class="modal-content">
            <!-- クローズボタン -->
            <button class="modal-close" onclick="closeModal()">×</button>

            <div class="modal-body" id="modalBody">
                <!-- 詳細内容がここに実装される -->
            </div>

            <!-- 削除ボタン -->
            <div class="modal-footer" style="text-align: right; margin-top: 20px; padding: 15px 0; border-top: 1px solid #eee;">
                <button onclick="deleteContact()"
                        class="btn btn-delete"
                        style="background-color: #e63939; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer;">
                    削除する
                </button>
            </div>
        </div>
    </div>

    <style>
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .modal-close {
            position: absolute;
            top: 15px;
            left: 15px;
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #666;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            color: #333;
        }

        .modal-body {
            margin-top: 20px;
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


    <script>
    let currentContactId = null;

    function openModal(contactId) {
        currentContactId = contactId;

        fetch(`/admin/contacts/${contactId}`)
            .then(response => response.json())
            .then(data => {
                const html = `
                    <div class="detail-row">
                        <div class="detail-label">お名前</div>
                        <div class="detail-value">${data.first_name} ${data.last_name}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">性別</div>
                        <div class="detail-value">${data.gender}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">メールアドレス</div>
                        <div class="detail-value">${data.email}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">電話番号</div>
                        <div class="detail-value">${data.tel}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">住所</div>
                        <div class="detail-value">${data.address}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">建物名</div>
                        <div class="detail-value">${data.building}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">お問い合わせ種別</div>
                        <div class="detail-value">${data.category}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">お問い合わせ内容</div>
                        <div class="detail-value detail-text">${data.detail}</div>
                    </div>
                `;
                document.getElementById('modalBody').innerHTML = html;
                document.getElementById('contactModal').style.display = 'flex';
            })
            .catch(error => {
                console.error('エラー:', error);
            });
    }

    function closeModal() {
        document.getElementById('contactModal').style.display = 'none';
    }

    function deleteContact() {
        if (!currentContactId) return;

        fetch(`/admin/delete/${currentContactId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            closeModal();
            location.reload();  // 成功・失敗問わず一覧を更新
        })
        .catch(error => {
            console.error('Error:', error);
            closeModal();
            location.reload();  // エラー時も更新
        });
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('contactModal');
        if (event.target === modal) {
            closeModal();
        }
    });
</script>
@endsection
