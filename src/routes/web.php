<?php

use Illuminate\Support\Facades\Route;

// Fortifyの認証ルートを有効化
Route::prefix('admin')->name('admin.')->group(function () {
    require __DIR__.'/auth.php';
});

use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== 公開側（一般ユーザー） ====================

// トップページ（任意でリダイレクト設定）
Route::get('/', function () {
    return redirect()->route('contacts.index');
});

// お問い合わせフォーム関連
Route::prefix('contacts')->name('contacts.')->group(function () {

    // お問い合わせ入力画面
    Route::get('/', [ContactController::class, 'index'])->name('index');

    // 確認画面
    Route::match(['get', 'post'], '/confirm', [ContactController::class, 'confirm'])->name('confirm');

    // 確認画面から修正して戻る用
    Route::post('/edit', [ContactController::class, 'edit'])->name('edit');

    // 送信処理
    Route::post('/store', [ContactController::class, 'store'])->name('store');

    // 完了画面
    Route::get('/thanks', [ContactController::class, 'thanks'])->name('thanks');
});

// ==================== 認証関連（Fortify使用） ====================

// ==================== 管理画面（ログイン必須） ====================

Route::prefix('admin')->name('admin.')->middleware('auth')
->group(function () {

    // 管理画面トップ（お問い合わせ一覧）
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // お問い合わせ詳細
    Route::get('/contacts/{contact}', [AdminController::class, 'show'])->name('contacts.show');

    // 検索
    Route::get('/search', [AdminController::class, 'index'])->name('search');

    // 検索リセット
    Route::get('/reset', [AdminController::class, 'index'])->name('reset');

    // お問い合わせ詳細
    Route::get('/contacts/{contact}', [AdminController::class, 'show'])->name('contacts.show');

    // お問い合わせ削除
    Route::delete('/delete/{contact}', [AdminController::class, 'destroy'])->name('contacts.delete');

    // CSVエクスポート（後で実装）
    Route::get('/export', [AdminController::class, 'export'])->name('export');
});
