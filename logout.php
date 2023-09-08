<?php
    session_start();
    // セッションを削除
    unset($_SESSION['loginPermission']);
    unset($_SESSION['registerUserName']);
    unset($_SESSION['userId']);

    if (!$_SESSION['loginPermission']) {
        // ログインページにリダイレクト
        header("Location: login.php");
    }
?>