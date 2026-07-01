<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * 誰でもこのリクエストを使える
     */
    public function authorize()
    {
        return true;
    }

    /**
     * バリデーションルール
     */
    public function rules()
    {
        return [
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'gender'       => 'required|in:1,2,3',
            'email'        => 'required|email|max:255',
            'tel1'         => 'required',
            'tel2'         => 'required',
            'tel3'         => 'required',
            'address'      => 'required|string|max:255',
            'building'     => 'nullable|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'detail'       => 'required|string|max:120',
        ];
    }

    /**
     * カスタムエラーメッセージ
     */
    public function messages()
    {
        return [
            'first_name.required' => '・姓を入力してください',
            'last_name.required'  => '・名を入力してください',
            'gender.required'     => '・性別を選択してください',
            'email.required'      => '・メールアドレスを入力してください',
            'email.email'         => '・メールアドレスはメール形式で入力してください',

            'tel1.required'       => '・電話番号を入力してください',
            'tel2.required'       => '・電話番号を入力してください',
            'tel3.required'       => '・電話番号を入力してください',
            'tel1.regex'          => '・電話番号は半角数字で入力してください',
            'tel2.regex'          => '・電話番号は半角数字で入力してください',
            'tel3.regex'          => '・電話番号は半角数字で入力してください',
            'tel1.digits_between' => '・電話番号は5桁までの数字で入力してください',
            'tel2.digits_between' => '・電話番号は5桁までの数字で入力してください',
            'tel3.digits_between' => '・電話番号は5桁までの数字で入力してください',
            'address.required'    => '・住所を入力してください',
            'category_id.required'=> '・お問い合わせ種別を選択してください',
            'detail.required'     => '・お問い合わせ内容を入力してください',
            'detail.max'          => '・お問い合わせ内容は120文字以内で入力してください',
        ];
    }

    /**
     * 属性名（日本語表示用）
     */
    public function attributes()
    {
        return [
            'first_name'  => '姓',
            'last_name'   => '名',
            'gender'      => '性別',
            'email'       => 'メールアドレス',
            'tel1'        => '電話番号',
            'tel2'        => '電話番号',
            'tel3'        => '電話番号',
            'address'     => '住所',
            'building'    => '建物名',
            'category_id' => 'お問い合わせ種別',
            'detail'      => 'お問い合わせ内容',
        ];
    }

    /**
     * バリデーション後の処理
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            foreach (['tel1', 'tel2', 'tel3'] as $field) {
                $value = $this->input($field);

                if (!empty($value)) {
                    // 全角数字をチェック
                    if (preg_match('/[０-９]/', $value)) {
                        $validator->errors()->add($field, '・電話番号は半角数字で入力してください');
                    }
                    // 5桁を超えるチェック
                    elseif (strlen($value) > 5) {
                        $validator->errors()->add($field, '・電話番号は5桁までの数字で入力してください');
                    }
                    // 半角数字以外をチェック
                    elseif (!preg_match('/^[0-9]+$/', $value)) {
                        $validator->errors()->add($field, '・電話番号は半角数字で入力してください');
                    }
                }
            }
        });
    }
}
