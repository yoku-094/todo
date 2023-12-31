<?php
    require_once('login_check.php');
    require('db_connect.php');
    session_start();

    // エラーメッセージがあれば表示
    if ($_SESSION["userDeleteErrorMessage"]) {
        $error_message = $_SESSION["userDeleteErrorMessage"];
    }
    unset($_SESSION["userDeleteErrorMessage"]);

    $user_id = $_SESSION["userId"];
    $user_name = $_SESSION["registerUserName"];

    $pdo = db_connect();
    try {
        $sql = "SELECT * FROM posts WHERE user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $count = $stmt->rowCount();
      } catch (PDOException $e) {
        echo $e->getMessage();
        die();
      }
    // 取得できたタイトルと本文を変数に入れておく
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $remainding_task_count = $row.count();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集画面</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="title-area">
        <h1>ユーザー削除</h1>
    </div>
    <div class="delete-user-content-area">
        <div class="delete-user-content" name="name" style="margin-bottom: 20px;">削除ユーザー：&nbsp;<?php echo $user_name; ?></div>
        <div class="delete-user-content" >登録タスク数：&nbsp;<?php echo $count; ?></div>
    </div>
    <form action="user_delete_done.php" method="POST">
        <input type="password" class="input-area" name="password" placeholder="パスワードを入力してください" required> <br>
        <input type="submit" class="input-area submit" name="submit" value="削除" onclick="return userDeleteConfirm()">
    </form>
    <p style="color: red;"><?php echo $error_message ?></p>
    <p><a href="main.php" class="return-main">メイン画面に戻る</a></p>

    <script>
        function userDeleteConfirm() {
            let confirmResult = confirm("ユーザーを削除します。\nよろしいですか？\n\n【！】削除後にデータを復元することはできません");
            let result = false;
            if (confirmResult) {
                result = true;
            }
            return result;
        }
    </script>
</body>

</html>