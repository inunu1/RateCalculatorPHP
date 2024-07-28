# Laravel Sailでのキャッシュクリアコマンド

Laravel Sailを使用して開発している場合、以下のコマンドを使用してキャッシュをクリアできます。

## 1. 全般的なキャッシュをクリアする

./vendor/bin/sail artisan cache:clear

## 2. ルートキャッシュをクリアする

./vendor/bin/sail artisan route:clear

## 3. コンフィグキャッシュをクリアする

./vendor/bin/sail artisan config:clear

## 4. ビューキャッシュをクリアする

./vendor/bin/sail artisan view:clear

## 5. オプティマイズキャッシュをクリアする

./vendor/bin/sail artisan optimize:clear


