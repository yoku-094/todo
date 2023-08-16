<?php
    require('db_connect.php');

    // URLのパラメータを取得
    $id = $_GET['id'];

    $pdo = db_connect();

    try {
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
      
        // 登録完了時の処理（メインページにリダイレクト）
        header("Location: main.php");
        exit;
      } catch (PDOException $e) {
        echo $e->getMessage();
        die();
      }
?>