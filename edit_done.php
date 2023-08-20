<?php
    require_once('login_check.php');
    require('db_connect.php');

    $id      = $_POST['id'];
    $title   = $_POST['title'];
    $content = $_POST['content'];
    $submit  = $_POST['submit'];

    $pdo = db_connect();
    try {
        $sql = "UPDATE posts SET title = :title, content = :content WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->execute();
    
      } catch (PDOException $e) {
        echo $e->getMessage();
        die();
      }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>編集完了画面</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="title-area">
        <h1>編集完了画面</h1>
    </div>
    <div class="text-area">
        <p>ID：<?php echo $id?>を編集しました。</p>
        <p><a href="main.php">メイン画面に戻ります。</a></p>
    </div>
</body>

</html>