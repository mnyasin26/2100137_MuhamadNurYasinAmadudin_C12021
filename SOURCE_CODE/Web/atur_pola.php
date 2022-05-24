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
            <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
            </label>
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
            <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
            </label>
        </div>

        <div class="desc">
            <p>silakan ketuk pola baru pada brankas.</p>
            <p>jika sudah matikan kembali switch di atas</p>
        </div>
    </section>
</body>

</html>