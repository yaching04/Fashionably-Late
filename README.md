# Fashionably-Late

## 環境構築
cd coachtehch
git clone git@github.com:Estra-Coachtech/laravel-docker-template.git
mkdir Fashionably-Late
mv laravel-docker-template Fashionably-Late
cd Fashionably-Late

GutHubで新しいリモートリポジトリ作成「Fashionably-Late」
git remote set-url origin git@github.com:yaching04/Fashionably-Late.git
git remote -v
git add .
git commit -m "リモートリポジトリの変更"
git push origin main

Dockerの設定
docker-compose up -d --build

Laravel のパッケージのインストール
docker-compose exec php bash
composer install

.envファイルの作成・修正
cp .env.example .env

APP_KEY 生成
php artisan key:generate
