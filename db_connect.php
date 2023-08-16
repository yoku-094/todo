<?php
    // DB名
    define('DB_DATABASE', 'todo');
    // MySQLのユーザー名
    define('DB_USERNAME', 'root');
    // MySQLのログインパスワード
    define('DB_PASSWORD', 'root');
    // DSN
    define('DSN', 'mysql:host=localhost;charset=utf8;dbname='.DB_DATABASE);

    // DB接続用の関数
    function db_connect() {
        try {
            // PDOインスタンスの作成
            $pdo = new PDO(DSN, DB_USERNAME, DB_PASSWORD);
            // エラー処理方法の設定
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            die();
        }
    }
?>