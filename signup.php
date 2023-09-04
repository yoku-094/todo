<?php
    require('db_connect.php');
    session_start();

    // エラーメッセージがあれば表示
    if ($_SESSION["signupErrorMessage"]) {
        $error_message = $_SESSION["signupErrorMessage"];
    }

    $name = $_POST['name'];
    $password = $_POST['password'];
    $submit = $_POST['submit'];

    if (!empty($submit)) {
        $pdo = db_connect();

        try {
            $sql = "INSERT INTO users (name, password) VALUES (:name, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":password", $password);
            $stmt->execute();

            // 登録完了画面表示用
            $_SESSION['registerUserName'] = $name;
            $_SESSION['registerPassword'] = $password;

            // 登録完了時の処理（登録完了ページにリダイレクト）
            header("Location: signup_done.php");
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
    <title>TODO/Sign up</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="title-area">
        <h1>ユーザー登録</h1>
    </div>
    <form action="" method="POST">
        <input type="text" class="input-area" name="name" placeholder="User Name" required> <br>
        <input type="password" id="password" class="input-area password" name="password" placeholder="Password" required> <br>
        <div class="toggle-password-disply-area">
            <a type="button" id="togglePasswordDisply" class="toggle-password-disply">パスワード表示切替え</a>
        </div>
        <input type="submit" class="input-area submit" name="submit" value="Sign up">
    </form>
    <p style="color: red;"><?php echo $error_message ?></p>
        <p><a href="login.php">ログイン</a></p>

    <script>
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePasswordDisply');

        toggleButton.addEventListener('click', () => {
            // パスワードのマスキングON・OFF切替え
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
    <style scope>
        .password {
            margin-bottom: 10px;
        }
        .toggle-password-disply-area {
            width: 600px;
            margin: 0 auto;
        }
        .toggle-password-disply {
            display: block;
            text-align: right;
            margin-bottom: 16px;
            color: rgb(73, 140, 255);
        }
        .toggle-password-disply:hover {
            cursor: pointer;
        }
    </style>
</body>

</html>