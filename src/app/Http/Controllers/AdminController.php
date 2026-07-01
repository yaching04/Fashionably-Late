<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

/**
 * AdminController
 *
 * 管理画面のお問い合わせ一覧・詳細・削除などを制御します。
 */
class AdminController extends Controller
{
    /**
     * 管理画面トップ（お問い合わせ一覧）
     */
    public function index()
    {
        $query = Contact::with('category')->latest();

        // 検索機能
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (request('gender')) {
            $query->where('gender', request('gender'));
        }

        if (request('category_id')) {
            $query->where('category_id', request('category_id'));
        }

        if (request('date_from')) {
            $query->whereDate('created_at', '>=', request('date_from'));
        }

        $contacts = $query->paginate(7)->withQueryString();   // 1ページあたり7件表示

        $categories = Category::all();

        return view('admins.admin', compact('contacts', 'categories'));
    }

    /**
     * お問い合わせ詳細（モーダル用）
     */
    public function show(Contact $contact)
    {
        $contact->load('category');

        // モーダル用にJSONを返す
        return response()->json([
            'first_name' => $contact->first_name,
            'last_name' => $contact->last_name,
            'gender' => match($contact->gender) {
                1 => '男性',
                2 => '女性',
                3 => 'その他',
                default => '不明'
            },
            'email' => $contact->email,
            'tel' => $contact->tel,
            'address' => $contact->address,
            'building' => $contact->building ?? 'なし',
            'category' => $contact->category->content ?? '未分類',
            'detail' => $contact->detail,
        ]);
    }

    /**
     * お問い合わせ削除
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.index')
                        ->with('success', 'お問い合わせを削除しました。');
    }

    /**
 * CSVエクスポート
 */
public function export()
{
    $contacts = Contact::with('category')->latest()->get();

    $csvHeader = [
        'ID',
        'お名前',
        '性別',
        'メールアドレス',
        '電話番号',
        '住所',
        '建物名',
        'お問い合わせ種別',
        'お問い合わせ内容',
        '投稿日時'
    ];

    $csvData = [];

    foreach ($contacts as $contact) {
        $csvData[] = [
            $contact->id,
            $contact->first_name . ' ' . $contact->last_name,
            match($contact->gender) {
                1 => '男性',
                2 => '女性',
                3 => 'その他',
                default => '不明'
            },
            $contact->email,
            $contact->tel,
            $contact->address,
            $contact->building ?? 'なし',
            $contact->category->content ?? '未分類',
            $contact->detail,
            $contact->created_at->format('Y-m-d H:i:s')
        ];
    }

    $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv; charset=utf-8',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ];

    $callback = function () use ($csvHeader, $csvData) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $csvHeader);

        foreach ($csvData as $row) {
            fputcsv($file, $row);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}
