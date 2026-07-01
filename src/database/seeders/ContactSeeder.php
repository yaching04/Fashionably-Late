<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Category;

/**
 * ContactSeeder
 *
 * contactsテーブルにテスト用のお問い合わせデータを登録します。
 * 管理画面作成時に一覧表示の確認用として使用します。
 */
class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->warn('⚠️ カテゴリがありません。先にCategorySeederを実行してください。');
            return;
        }

        $contacts = [
            [
                'category_id' => $categories[0]->id,
                'first_name'  => '山田',
                'last_name'   => '太郎',
                'gender'      => 1,
                'email'       => 'yamada@example.com',
                'tel'         => '090-1234-5678',
                'address'     => '東京都渋谷区神宮前1-1-1',
                'building'    => '渋谷スクエアA棟 1203',
                'detail'      => '新商品の在庫状況を教えてください。',
            ],
            [
                'category_id' => $categories[1]->id,
                'first_name'  => '佐藤',
                'last_name'   => '花子',
                'gender'      => 2,
                'email'       => 'sato@example.com',
                'tel'         => '080-9876-5432',
                'address'     => '神奈川県横浜市西区みなとみらい2-2-2',
                'building'    => null,
                'detail'      => 'サイトにログインできません。どうすればいいでしょうか？',
            ],
            [
                'category_id' => $categories[2]->id,
                'first_name'  => '鈴木',
                'last_name'   => '一郎',
                'gender'      => 1,
                'email'       => 'suzuki@example.com',
                'tel'         => '070-1111-2222',
                'address'     => '大阪府大阪市中央区難波3-3-3',
                'building'    => '難波ビル5階',
                'detail'      => '注文番号12345の商品がまだ届いていません。状況を確認してください。',
            ],
        ];

        // 追加のダミーデータ（32件）
        $firstNames = ['山田', '佐藤', '鈴木', '田中', '高橋', '伊藤', '渡辺', '中村'];
        $lastNames = ['太郎', '花子', '一郎', '美咲', '健太', 'あかり', '大輔', '優子'];

        for ($i = 1; $i <= 32; $i++) {
            $contacts[] = [
                'category_id' => $categories->random()->id,
                'first_name'  => $firstNames[array_rand($firstNames)],
                'last_name'   => $lastNames[array_rand($lastNames)],
                'gender'      => rand(1, 3),
                'email'       => 'test' . $i . '@example.com',
                'tel'         => '090-' . rand(1000,9999) . '-' . rand(1000,9999),
                'address'     => '東京都渋谷区神宮前' . rand(1, 9) . '-1-' . rand(1, 32),
                'building'    => rand(0,1) ? 'ビル' . rand(100, 999) : null,
                'detail'      => 'これはテスト' . $i . '番目のお問い合わせ内容です。商品に関する質問があります。',
            ];
        }

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }

        $this->command->info('✅ お問い合わせシーダー完了！ ' . count($contacts) . '件登録しました。');
    }
}
