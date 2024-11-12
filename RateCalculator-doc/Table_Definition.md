# テーブル設計

## 会員 テーブル設計

| 列名         | データ型          | 説明                             |
|--------------|-------------------|----------------------------------|
| `id`         | `increments`      | 会員ID（自動増分）              |
| `last_name`  | `string(20)`      | プレイヤーの姓                   |
| `first_name` | `string(20)`      | プレイヤーの名                   |
| `rating`     | `integer`         | プレイヤーのレーティング         |
| `created_at` | `timestamp`       | 登録日                           |
| `updated_at` | `timestamp`       | 更新日                           |

## 対局結果 テーブル設計

| 列名                 | データ型          | 説明                               |
|----------------------|-------------------|------------------------------------|
| `id`                 | `increments`      | 対局結果のID（自動増分）          |
| `winner_id`         | `string`          | 勝った人のID                       |
| `loser_id`          | `string`          | 負けた人のID                       |
| `winner_rate`       | `integer`         | 勝った人の対局時のレート           |
| `loser_rate`        | `integer`         | 負けた人の対局時のレート           |
| `game_date`         | `datetime`        | 対局日時                           |
| `calcrate_flag`  | `boolean`         | レーティング計算フラグ（trueで計算済み） |
| `created_at`        | `timestamp`       | 登録日                             |
| `updated_at`        | `timestamp`       | 更新日                  