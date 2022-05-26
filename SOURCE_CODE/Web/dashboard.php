<?php
session_start();
include('function.php');

if (!isset($_SESSION["login"])) {
    header("Location: ./index.php");
    exit;
}

// $result = tampil("SELECT * ...");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Knock Lock</title>
    <link rel="stylesheet" type="text/css" href="css/styleindex.css">
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
            <p>Selamat datang <?= $_SESSION['user'] ?> di aplikasi Smart Knock Device.</p>
            <p>Untuk menggunakan aplikasi ini hanya perlu menekan fitur-fitur yang ada pada side bar.</p>
            <img src="assets/images/Laptop-Dashboard.png" alt="laptop" class="laptop">
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
            <p>Selamat datang <?= $_SESSION['user'] ?> di aplikasi Smart Knock Device.</p>
            <p>Untuk menggunakan aplikasi ini hanya perlu menekan fitur-fitur yang ada pada side bar.</p>
        </div>
        <img src="assets/images/Laptop-Dashboard.png" alt="laptop" class="laptop">
        <img src="assets/images/dot-hijau.png" alt="doth" class="doth">
    </section>



</body>

</html>