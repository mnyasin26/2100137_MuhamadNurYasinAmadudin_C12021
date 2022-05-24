<?php
session_start();

require './config.php';

if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];

    $result = mysqli_query($conn, "SELECT USERNAME FROM `master` WHERE ID_MASTER = $id");
    $row = mysqli_fetch_assoc($result);

    if ($key === hash("sha256", $row["USERNAME"])) {
        $_SESSION["login"] = true;
        $_SESSION["user"] = $row["USERNAME"];
        $_SESSION["id_akun"] = $row["ID_MASTER"];
    }
}

if (isset($_SESSION["login"])) {
    header("Location: ./dashboard.php");
    exit;
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $result = mysqli_query($conn, "SELECT * FROM `master` WHERE USERNAME = '$username'");
    //echo $result;
    // $row = mysqli_fetch_assoc($result);
    // echo $row['PASSWORD'];
    // $password = password_hash('twentysix26', PASSWORD_DEFAULT);
    // echo $password;
    // exit;
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["PASSWORD"])) {
            $_SESSION["login"] = true;
            $_SESSION["user"] = $row["USERNAME"];
            $_SESSION["id_akun"] = $row["ID_MASTER"];

            // if (isset($_POST["remember"])) {
            //     setcookie("id", $row["id"], time() + 1800);
            //     setcookie("key", hash("sha256", $row["username"]), time() + 1800);
            // }

            header("Location: ./dashboard.php");
            exit;
        }
    }

    $error = true;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Knock Lock</title>
    <link rel="stylesheet" type="text/css" href="css/stylelogin-register.css">
</head>

<body>
    <div class="container">
        <div class="item logo">
            <img src="assets/images/Login Page - Desktop copy.png" alt="gambar" class="gambar">
        </div>
        <div class="item login">
            <div class="login-form">
                <u>Welcome!</u>
                <form role="form" action="" method="post">
                    <div class="form-group">
                        <h3>username</h3>
                        <input type="text" name="username" id="username" required>
                    </div>
                    <div class="form-group">
                        <h3>password</h3>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="login">Login</button>
                    </div>

                    <?php if (isset($error)) : ?>
                        <script>
                            alert('username atau password salah!')
                        </script>
                    <?php endif; ?>

                </form>
                <p>tidak punya akun? <a href="register.php" style="color: #56AB60">Sign Up</a></p>
            </div>
        </div>
    </div>


    <!-- <footer>
        <div class="bawah">
            <img src="assets/images/dot-putih.png" alt="dotp" class="dotp">
        </div>
    </footer> -->

    <script type="text/javascript" src="js/script.js"></script>
</body>

</html>

<!-- <!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Login | Arsip Buku</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="signin.css">
</head>

<body class="text-center">
    <form class="form-signin" action="" method="post">
        <img class="mb-4" src="icons8-the-flash-sign.svg" alt="" width="86" height="86">

        <h1 class="h3 mb-3 font-weight-normal">Arsip Buku</h1>

        <label for="username" class="sr-only">Username</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus>

        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

        <div class="checkbox mb-3">
            <label for="remember">
                <input type="checkbox" name="remember" id="remember"> Remember Me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block mt-4" type="submit" name="login">Login</button>


        <p class="mt-1">
            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="./register.php">
                Buat Akun
            </a>
        </p>
        
        <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
    </form>
</body>

</html> -->