<?php
    require_once('login_check.php');
    require('db_connect.php');
    session_start();

    $user_id = $_SESSION["userId"];
    $user_name= $_SESSION["registerUserName"];
    $password = $_POST["password"];
    $submit = $_POST["submit"];

    if (!empty($submit)) {
        $pdo = db_connect();
        try {
            $sql = "SELECT * FROM users WHERE id = :user_id AND name = :user_name AND password = :password";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":user_name", $user_name);
            $stmt->bindParam(":password", $password);
            $stmt->execute();
            $count = $stmt->rowCount();

            if ($count > 0) {
                $sql = "DELETE FROM users WHERE id = :user_id AND name = :user_name AND password = :password";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":user_id", $user_id);
                $stmt->bindParam(":user_name", $user_name);
                $stmt->bindParam(":password", $password);
                $stmt->execute();

                // セッションを削除
                unset($_SESSION['loginPermission']);
                unset($_SESSION['registerUserName']);
                unset($_SESSION['userId']);

            } else {
                $_SESSION["userDeleteErrorMessage"] = "パスワードが違います";
                header("Location: user_delete.php");
                exit;
            }
        
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>削除完了画面</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="title-area">
        <h1>ユーザーの削除が完了しました</h1>
    </div>
    <div class="text-area">
        <p>５秒後に会員登録画面に移動します。</p>
        <?php header("refresh:5; signup.php"); ?>
        <p>画面が移動しない場合は<a href="signup.php"> こちら </a>をクリックしてください。</p>
    </div>
</body>

</html>