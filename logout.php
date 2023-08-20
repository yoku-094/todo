<?php
    session_start();
    // セッションを削除
    unset($_SESSION['loginPermission']);

    if (!$_SESSION['loginPermission']) {
        // ログインページにリダイレクト
        header("Location: login.php");
    }
?>