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

上記コマンドを打つ