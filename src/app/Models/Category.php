<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Category Model
 *
 * お問い合わせのカテゴリ（種類）を管理するモデルです。
 * 例：商品問い合わせ、技術的な質問、お客様サポート など
 */
class Category extends Model
{
    use HasFactory;   // テスト用ダミーデータを簡単に作れる機能

    /**
     * 一括代入を許可するカラム
     */
    protected $fillable = [
        'content',     // カテゴリ名（仕様書では「content」）
    ];

    /**
     * リレーション設定
     * 1つのカテゴリに対して、複数の問い合わせ（Contact）が紐づく
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
