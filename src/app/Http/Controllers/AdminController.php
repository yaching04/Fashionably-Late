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

        // モーダル用にHTMLを返す
        return view('admins.show', compact('contact'));
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
     * CSVエクスポート（後で実装）
     */
    public function export()
    {
        return redirect()->back()->with('info', 'CSVエクスポート機能は現在準備中です。');
    }
}
