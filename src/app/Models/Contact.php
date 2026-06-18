<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Contact Model
 *
 * お問い合わせ本体を管理するメインのモデルです。
 * フォームから送られてきた情報をデータベースに保存・取得します。
 */
class Contact extends Model
{
    use HasFactory;

    /**
     * 一括代入を許可するカラム
     * ここに書いていないカラムは、$contact->xxx = '値'; で直接代入できない（セキュリティ）
     */
    protected $fillable = [
        'category_id',
        'first_name',
        'last_name',
        'gender',
        'email',
        'tel',
        'address',
        'building',
        'detail',
    ];

    /**
     * リレーション設定（多対1）
     * 1つのお問い合わせは、必ず1つのカテゴリに所属する
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * アクセサ（取得時の便利機能）
     * $contact->full_name で「山田 太郎」のように結合して取得できる
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * アクセサ（性別を日本語表示）
     * $contact->gender_label で「男性」「女性」などが取得できる
     */
    public function getGenderLabelAttribute()
    {
        return match($this->gender) {
            1 => '男性',
            2 => '女性',
            3 => 'その他',
            default => '不明',
        };
    }
}
