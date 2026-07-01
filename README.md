# Fashionably-Late

## 環境構築
- cd coachtehch  
- git clone git@github.com:Estra-Coachtech/laravel-docker-template.git  
- mkdir Fashionably-Late  
- mv laravel-docker-template Fashionably-Late  
- cd Fashionably-Late  

**GutHubで新しいリモートリポジトリ作成「Fashionably-Late」**  
- git remote set-url origin git@github.com:yaching04/Fashionably-Late.git  
- git remote -v  
- git add .  
- git commit -m "リモートリポジトリの変更"  
- git push origin main  

*Dockerの設定**  
- docker-compose up -d --build  

**Laravel のパッケージのインストール**  
- docker-compose exec php bash  
- composer install  

**.envファイルの作成・修正**  
- cp .env.example .env  

**APP_KEY 生成**  
- php artisan key:generate  

**マイグレーション**  
- php artisan make:migration create_categories_table　
- php artisan make:migration create_contacts_table　
- php artisan make:model Category　
- php artisan make:model Contact　
- php artisan make:request ContactRequest　

- php artisan make:seeder CategorySeeder　
- php artisan make:seeder ContactSeeder　

- php artisan migrate:fresh --seed　

## 使用技術

バックエンド
- **PHP**: 8.5
- **Laravel**: 8.83.8（Fortify使用）
- **MySQL**: 8.0

フロントエンド
- **Blade** (Laravelテンプレートエンジン)
- **CSS3** (純粋CSS、Tailwind未使用)
- **JavaScript** (モーダルなど一部インタラクション)

開発環境
- **Docker** + **Docker Compose** (Laravel Sailベース)
- **Laravel Sail** (PHP, MySQL, Nginx, phpMyAdmin)
- **Composer** (依存関係管理)

その他
- **Fortify** (認証機能)
- **Eloquent ORM** (モデル)
- **Migration & Seeder** (DB初期化)
- **Git** (バージョン管理)



