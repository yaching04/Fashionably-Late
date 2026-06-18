<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

/**
 * CategorySeeder
 *
 * categoriesテーブルに初期カテゴリデータを登録します。
 * お問い合わせフォームで選択できる「問い合わせ種類」を準備します。
 */
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['content' => '商品について'],
            ['content' => '技術的な質問'],
            ['content' => '配送・発送について'],
            ['content' => 'お支払い・請求について'],
            ['content' => '返品・交換について'],
            ['content' => 'その他のお問い合わせ'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ カテゴリシーダー完了！ ' . count($categories) . '件登録しました。');
    }
}
