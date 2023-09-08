<?php
    require_once('login_check.php');
    require('db_connect.php');
    session_start();

    $user_name = $_SESSION["registerUserName"];
    $user_id = $_SESSION["userId"];

    $pdo = db_connect();
    try {
        $sql = "SELECT * FROM posts WHERE user_id = :user_id  ORDER BY id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
    } catch(PDOException $e) {
        echo $e->getMessage();
        die(); 
    }
?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- 共通 CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title>TODO/main page</title>
  </head>
  <body>
    <div class="main-page-title">
        <h1><?php echo $user_name; ?> 's&emsp;TODO</h1>
    </div>
    <div class="btn-area">
        <div class="create-btn-area">
            <a href="create.php" ><button type="button" class="btn btn-primary">新規登録</button></a>
        </div>
        <div class="logout-btn-area">
            <a href="logout.php" ><button type="button" class="btn btn-danger">ログアウト</button></a>
        </div>
    </div>
    
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <div class="table-background">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col" class="col-todo-id">No</th>
                <th scope="col" class="col-todo-title">課題</th>
                <th scope="col" class="col-todo-content">内容</th>
                <th scope="col" class="col-todo-datetime">作成日時</th>
                <th scope="col" class="col-todo-edit">編集</th>
                <th scope="col" class="col-todo-delete">削除</th>
            </tr>
            </thead>
            <tbody>
            <?php 
                $todo_no = 1;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) :
            ?>
                <tr>
                <td><?php echo $todo_no; ?></td>
                <td><?php echo $row["title"]; ?></td>
                <td><?php echo $row["content"]; ?></td>
                <td><?php echo $row["time"]; ?></td>
                <td><a href="edit.php?id=<?php echo $row['id'];?>">編集</a></td>
                <td><a href="delete.php?id=<?php echo $row['id'];?>">削除</a></td>
                </tr>
            <?php
                $todo_no++;
                endwhile;
            ?>
            </tbody>
        </table>
    </div>
  </body>
</html>