<?php
    require('db_connect.php');

    $title = $_POST['title'];
    $content = $_POST['content'];
    $submit = $_POST['submit'];

    if (!empty($submit)) {
        $pdo = db_connect();

        try {
            $sql = "INSERT INTO posts (title, content) VALUES (:title, :content)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":content", $content);
            $stmt->execute();

            // 登録完了時の処理（メインページにリダイレクト）
            header("Location: main.php");
        } catch (PDOException $e) {
            echo $e->$getMessage();
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
    <title>TODO/new registration</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="title-area">
        <h1>新規登録</h1>
    </div>
    <form action="" method="POST">
        <input type="text" class="input-area" name="title" placeholder="Title" required> <br>
        <input type="text" class="input-area" name="content" placeholder="Content" required> <br>
        <input type="submit" class="input-area submit" name="submit" value="登録">
    </form>
    <a href="main.php" class="return-main">メイン画面に戻る</a>
</body>

</html>