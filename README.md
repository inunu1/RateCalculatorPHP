## RateCalculator

環境構築手順

1:プロジェクト作成

    curl -s https://laravel.build/RateCalculator | bash

    上記コマンドで作成された

2:プロジェクト起動

    config\session.php
    .env

    上記ファイルのSESSION_DRIVERがdatabaseだと起動しないので、fileに変更すると起動する
    
3:phpmyadminの追加

    phpmyadmin:
        image: phpmyadmin/phpmyadmin
        links:
          - mysql:mysql
        ports:
          - 8080:80
        environment:
            MYSQL_USERNAME: '{DB_USERNAME}'
            MYSQL_ROOT_PASSWORD: '{DB_PASSWORD}'
            PMA_HOST: mysql
        networks:
            - sail

docker-compose.ymlに上記ソースを追記してphpmyadminが使えるようになった。

4:ログイン認証実装

    composer require laravel/breeze --dev

    php artisan breeze:install

    ./vendor/bin/sail artisan migrate

上記コマンドを上から順に打ち、Localhostにアクセスすると、LaravelのtopページにLoginとregisterのリンクが追加される。

5:日本語化

    config/app.phpのtimezoneを'Asia/Tokyo'に

    config/app.phpのLocaleを'Ja'に

    https://github.com/askdkc/breezejp?tab=readme-ov-file#readmeに記載の下記コマンドを入力

    composer require askdkc/breezejp --dev

    ./vendor/bin/sail artisan breezejp