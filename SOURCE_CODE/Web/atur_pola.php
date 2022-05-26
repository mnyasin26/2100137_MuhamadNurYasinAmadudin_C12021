<?php
session_start();
include './config.php';

if (!isset($_SESSION["login"])) {
    header("Location: ./index.php");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Knock Lock</title>
    <link rel="stylesheet" type="text/css" href="css/stylepola.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

</head>

<body>
    <nav>
        <div class="wrapper">
            <div class="atas"><a href=''>Smart Knock Lock</a></div>
        </div>
    </nav>

    <!--Untuk Desktop-->
    <div class="sidebar">
        <header>Menu</header>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-qrcode"></i>Dashboard</a></li>
            <li><a href="cek_baterai.php"><i class="fa-solid fa-battery-full"></i>Cek Baterai</a></li>
            <li><a href="atur_pola.php"><i class="fa-solid fa-arrows-rotate"></i>Atur Ulang Pola</a></li>
            <li><a href="cek_riwayat.php"><i class="fa-solid fa-list"></i>Cek Riwayat</a></li>
            <li><a href="logout.php"><i class="fa-solid fa-power-off"></i>Log Out</a></li>
        </ul>
    </div>

    <section class="isidesktop">
        <img src="assets/images/Logo Smart Knock Lock.png" alt="logo" class="logo">
        <div class="desc">
            <p>atur ulang pola</p>
        </div>

        <div class="container">
            <form method="post">
                <label class="switch">
                    <input type="checkbox" name="switch" class="input-switch">
                    <span class="slider"></span>
                </label>
            </form>
        </div>

        <div class="desc">
            <p>silakan ketuk pola baru pada brankas.</p>
            <p>jika sudah matikan kembali switch di atas</p>
        </div>
        <!-- <img src="assets/images/dot-hijau.png" alt="doth" class="doth"> -->
    </section>

    <!--Untuk Mobile-->
    <input type="checkbox" id="check">
    <label for="check">
        <i class="fa-solid fa-bars" id="btn"></i>
    </label>

    <div class="downbar">
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-qrcode"></i>Dashboard</a></li>
            <li><a href="cek_baterai.php"><i class="fa-solid fa-battery-full"></i>Cek Baterai</a></li>
            <li><a href="atur_pola.php"><i class="fa-solid fa-arrows-rotate"></i>Atur Ulang Pola</a></li>
            <li><a href="cek_riwayat.php"><i class="fa-solid fa-list"></i>Cek Riwayat</a></li>
            <li><a href="logout.php"><i class="fa-solid fa-power-off"></i>Log Out</a></li>
        </ul>
    </div>

    <section class="isimobile">
        <img src="assets/images/Logo Smart Knock Lock.png" alt="logo" class="logo">
        <div class="desc">
            <p>atur ulang pola</p>
        </div>

        <div class="container">
            <form method="post">
                <label class="switch">
                    <input type="checkbox" name="switch" class="input-switch">
                    <span class="slider"></span>
                </label>
            </form>
        </div>

        <div class="desc">
            <p>silakan ketuk pola baru pada brankas.</p>
            <p>jika sudah matikan kembali switch di atas</p>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>


    <script>
        var obj = {};
        obj.isPressed = 0;
        $('.input-switch').change(function() {
            if (this.checked) {
                obj.isPressed = "1";
                $test = JSON.stringify(obj)
                console.log("Pressed!", $test);
                $.ajax({
                    type: 'POST',
                    url: "./api/pola_update.php",
                    data: {
                        isPressed: 1,
                        id_master: <?= $_SESSION['id_akun'] ?>,
                    },
                    // success: function() {
                    //     alert('input data berhasil');
                    // }
                });
            } else {
                console.log("No Pressed!")
                obj.isPressed = 0;
                $.ajax({
                    type: 'POST',
                    url: "./api/pola_update.php",
                    data: {
                        isPressed: 0,
                        id_master: <?= $_SESSION['id_akun'] ?>,
                    },
                    // success: function() {
                    //     alert('input data berhasil');
                    // }
                });
            }
        });
    </script>
</body>

</html>