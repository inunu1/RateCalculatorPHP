# 会員テーブル設計

| 論理名 (Japanese)      | 物理名 (English)     | 型               | 属性                  | 説明                |
|---------------------|--------------------|------------------|-----------------------|---------------------|
| 会員ID              | player_id          | unsigned integer | primary key, auto increment | ユニークな会員識別子 |
| 姓                  | last_name          | string           | not null              | 会員の苗字          |
| 名                  | first_name         | string           | not null              | 会員の名前          |
| レーティング        | rating             | integer          | not null              | 会員のレーティング  |
| 登録日              | registered_at      | timestamp        | not null              | 会員登録日          |
| 更新日              | updated_at         | timestamp        | not null              | レコード更新日      |
| レーティング計算フラグ | calcrate_flag      | boolean          | default false         | レーティング計算が必要かどうか |
