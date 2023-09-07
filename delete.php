<?php
    require_once('login_check.php');
    require('db_connect.php');
    session_start();

    $user_id = $_SESSION["userId"];
    // URLのパラメータを取得
    $id = $_GET['id'];

    $pdo = db_connect();

    try {
        $sql = "DELETE FROM posts WHERE user_id = :user_id AND id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":user_id", $user_id);
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