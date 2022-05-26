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
    <link rel="stylesheet" type="text/css" href="css/styleriwayat.css">
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
        <div class="t-container">
            <table class="tabel1" id="displayData">



            </table>
        </div>





        <!-- <div class="footer">
            <img src="assets/images/dot-hijau.png" alt="doth" class="doth">
        </div> -->

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
        <table class="tabel1" id="displayData2">



        </table>


    </section>
</body>

<script>
    setInterval(() => {
        const param = {
            id_master: "<?= $_SESSION['id_akun'] ?>"
        };
        console.log(JSON.stringify(param))

        fetch('http://192.168.100.59/rpl/esp32/api/api.php?data=getall', {
                method: 'POST', // or 'PUT'
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(param),
            })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                console.log(data);
                let html = `<tr>
                                <th>no</th>
                                <th>tanggal dan waktu</th>
                                <th>status</th>
                            </tr>`;
                //console.log(data);
                let counter = 0;
                data.data.forEach(element => {
                    counter += 1
                    state = ``
                    if (element.STATUS_RIWAYAT == 0) {
                        state = `Gagal Membuka`
                    } else {
                        state = `Berhasil Membuka`
                    }
                    html += `
                <tr>
                    <td>${counter}</td>
                    <td>${element.RIWAYAT_BRANKAS}</td>
                    <td>${state}</td>
                </tr>
                `
                });
                document.getElementById('displayData').innerHTML = html;
                document.getElementById('displayData2').innerHTML = html;
            });


    }, 1000);
</script>

</html>