<?php

include('function.php');

if (isset($_POST["register"])) {
    if (registrasi($_POST) > 0) {
        echo "
        <script>
            alert('Data berhasil ditambahkan');
            document.location.href = 'index.php';
        </script>
    ";
    } else {
        echo mysqli_error($conn);
    }
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
                        <h3>email</h3>
                        <input type="email" name="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <h3>username</h3>
                        <input type="username" name="username" id="username" required>
                    </div>
                    <div class="form-group">
                        <h3>password</h3>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="form-group">
                        <h3>confirm password</h3>
                        <input type="password" name="password2" id="password" required>
                    </div>
                    <div class="form-group">
                        <h3>device code</h3>
                        <input type="text" name="code" id="code" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="register">Sign Up</button>
                    </div>
                    <?php if (isset($error)) : ?>
                        <script>
                            alert('kolom tidak boleh kosong!')
                        </script>
                    <?php endif; ?>
                </form>
                <p>sudah punya akun? <a href="index.php" style="color: #56AB60">Login</a></p>
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

<!-- </html>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Register | Arsip Buku</title>

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
        <input style="margin-bottom: 0;" type="password" name="password" id="password" class="form-control" placeholder="Password" required>

        <label for="password" class="sr-only">Confirm Password</label>
        <input type="password" name="password2" id="password" class="form-control" placeholder="Confirm Password" required>

        <label for="email" class="sr-only">Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>

        <label for="nama" class="sr-only">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Lengkap" required>

        <div class="checkbox mb-3">
            <label for="remember">
                <input type="checkbox" name="remember" id="remember"> Remember Me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block mt-4" type="submit" name="register">Register</button>
        <p class="mt-1">
            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline" href="./index.php">
                Punya Akun
            </a>
        </p>
        <?php if (isset($error)) : ?>
            <script>
                alert('kolom tidak boleh kosong!')
            </script>
        <?php endif; ?>
        <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
    </form>
</body>

</html> -->