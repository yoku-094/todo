<?php
    require('db_connect.php');
    session_start();

    // 以前のエラーメッセージがあれば削除
    if ($_SESSION["signupErrorMessage"]) {
        unset($_SESSION["signupErrorMessage"]);
    }

    $name   = $_SESSION['registerUserName'];
    $password = $_SESSION['registerPassword'];

    $pdo = db_connect();
    try {
        $sql = "SELECT * FROM users WHERE name = :name AND password = :password";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }
    unset($_SESSION['registerUserName']);
    unset($_SESSION['registerPassword']);

    if (!$row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // エラーメッセージ表示のため
        $_SESSION["signupErrorMessage"] = "エラーが発生しました。再度登録してください。";
        // 登録が確認できなかったら会員登録画面にリダイレクト
        header("Location: signup.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO/Sign up</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="title-area">
        <h1>ユーザー登録完了画面</h1>
    </div>
    <div class="text-area">
        <p>以下のとおり登録しました。</p>
        <p>User Name：<?php echo $name?></p>
        <p>Password：<?php echo $password?></p>
        <p><a href="login.php">ログイン</a></p>
    </div>
</body>

</html>