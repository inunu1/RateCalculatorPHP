<!-- resources/views/player/create.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>会員登録フォーム</title>
</head>
<body>
    <h1>会員登録フォーム</h1>
    
        @csrf <!-- CSRF保護のためのトークン -->

        <!-- 姓 -->
        <div>
            <label for="last_name">姓:</label>
            <input type="text" id="last_name" name="last_name" required>
        </div>

        <!-- 名 -->
        <div>
            <label for="first_name">名:</label>
            <input type="text" id="first_name" name="first_name" required>
        </div>

        <!-- レーティング -->
        <div>
            <label for="rating">レーティング:</label>
            <input type="number" id="rating" name="rating" required>
        </div>

        <!-- レーティング計算フラグ -->
        <div>
            <label for="calcrate_flag">レーティング計算フラグ:</label>
            <input type="checkbox" id="calcrate_flag" name="calcrate_flag">
        </div>

        <button type="submit">登録</button>
    </form>
</body>
</html>
