<?php
    session_start();
    if (!($_SESSION["loginPermission"])) {
        // ログインが確認できない場合はログインページにリダイレクト
        header("Location: login.php");
        exit;
    }
?>