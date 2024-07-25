<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規会員登録フォーム</title>
</head>
<body>
    <h1>新規会員登録フォーム</h1>
    <form action="{{ route('members.store') }}" method="POST">
        <!-- CSRF保護のためのトークン（Laravelでは必須） -->
        @csrf

        <div>
            <label for="last_name">姓:</label>
            <input type="text" id="last_name" name="last_name" required>
        </div>

        <div>
            <label for="first_name">名:</label>
            <input type="text" id="first_name" name="first_name" required>
        </div>

        <div>
            <label for="rating">レーティング:</label>
            <input type="number" id="rating" name="rating" required>
        </div>

        <div>
            <label for="registered_at">登録日:</label>
            <input type="datetime-local" id="registered_at" name="registered_at" required>
        </div>

        <div>
            <label for="updated_at">更新日:</label>
            <input type="datetime-local" id="updated_at" name="updated_at" required>
        </div>

        <div>
            <label for="calcrate_flag">レーティング計算フラグ:</label>
            <input type="checkbox" id="calcrate_flag" name="calcrate_flag" value="1">
        </div>

        <div>
            <button type="submit">登録</button>
        </div>
    </form>
</body>
</html>
