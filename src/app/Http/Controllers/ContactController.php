<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;

/**
 * ContactController
 */
class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('contacts.index', compact('categories'));
    }

            /**
     * 確認画面を表示
     */
    public function confirm(ContactRequest $request)
    {
        $validated = $request->validated();

        $category = Category::find($validated['category_id'] ?? null);

        return view('contacts.confirm', [
            'validated' => $validated,
            'category'  => $category,
        ])->withInput($request->all());   // old()用に強く入力値を保持
    }


        /**
     * 確認画面から「修正する」で入力画面に戻る専用処理
     */
    public function edit(ContactRequest $request)
    {
        // 入力値を保持したまま入力画面に戻る
        return redirect()->route('contacts.index')->withInput($request->all());
    }

    /**
     * 保存処理
     */
    public function store(ContactRequest $request)
    {
        $validated = $request->validated();

        $tel = ($validated['tel1'] ?? '') . '-' . ($validated['tel2'] ?? '') . '-' . ($validated['tel3'] ?? '');

        $contactData = [
            'category_id' => $validated['category_id'],
            'first_name'  => $validated['first_name'],
            'last_name'   => $validated['last_name'],
            'gender'      => $validated['gender'],
            'email'       => $validated['email'],
            'tel'         => $tel,
            'address'     => $validated['address'],
            'building'    => $validated['building'] ?? null,
            'detail'      => $validated['detail'],
        ];

        Contact::create($contactData);

        return redirect()->route('contacts.thanks') ->with('success', 'お問い合わせを送信しました。ありがとうございます。');
    }

    public function thanks()
    {
        return view('contacts.thanks');
    }
}
