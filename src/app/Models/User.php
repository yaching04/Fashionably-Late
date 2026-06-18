<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User Model
 *
 * このモデルは「usersテーブル」と連携するクラスです。
 * ユーザーのログイン認証（Fortify）に関わる重要なモデルです。
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;   // ファクトリー機能と通知機能を有効化

    /**
     * 一括代入を許可するカラム（セキュリティのため、許可したものだけ保存可能）
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * JSONなどに変換する時に隠す（非表示にする）カラム
     * パスワードなどは絶対に外部に漏らさないようにする
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 型変換設定
     * 日付などは自動でCarbon（日付オブジェクト）に変換される
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
