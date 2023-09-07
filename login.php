<?php
    // DB接続用ファイルの読込（db_connectメソッド使用のため）
    require('db_connect.php');
    session_start();

    // エラーメッセージがあれば削除
    if($_SESSION["loginErrorMessage"]) {
        unset($_SESSION["loginErrorMessage"]);
    }

    // フォーム送信された値の取得
    $name     = $_POST['name'];
    $password = $_POST['password'];
    $submit   = $_POST['submit'];

    // ログインの処理（$submitが空ではない＝ログインボタン押下）
    if (!empty($submit)) {
        $pdo = db_connect();
        try {
            $sql = "SELECT * FROM users WHERE name = :name AND password = :password";
            $stmt = $pdo->prepare($sql);
            // :name、:password に対応する値を設定
            // bindParamを使うと、WHERE句の値を後から入れることができる
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'エラー：' . $e->getMessage();
            die();
        }

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // name、password が一致したらセッションに保持
            $_SESSION["loginPermission"] = true;
            $_SESSION["userId"] = $row["id"];

            // メイン画面にリダイレクト
            header("Location: main.php");
            exit;
        } else {
            $_SESSION["loginErrorMessage"] = "パスワードか名前に間違いがあります。";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO/login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="title-area">
        <h1>ログイン</h1>
    </div>
    <form action="" method="POST">
        <input type="text" class="input-area" name="name" placeholder="ユーザー名" required> <br>
        <input type="password" class="input-area" name="password" placeholder="パスワード" required> <br>
        <input type="submit" class="input-area submit" name="submit" value="Log in">
    </form>
    <p style="color: red;"><?php echo $_SESSION["loginErrorMessage"] ?></p>
    <p><a href="signup.php" class="link-signup">会員登録はこちら</a></p>
</body>

</html>