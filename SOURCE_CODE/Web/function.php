<?php
include('config.php');

function registrasi($data)
{
    global $conn;

    $username = strtolower(stripslashes($data['username']));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);
    $mail = strtolower(stripslashes($data['email']));
    $device_code = strtoupper(stripslashes($data['code']));
    $id_master = '';


    //cek email sudah ada atau blm
    $check_mail = mysqli_query($conn, "SELECT EMAIL FROM `master` WHERE EMAIL='$mail'");
    if (mysqli_fetch_assoc($check_mail)) {
        echo "
        <script>
        alert('email sudah terdaftar');
        </script>
        ";
        return false;
    }
    $check_user = mysqli_query($conn, "SELECT USERNAME FROM `master` WHERE USERNAME='$username'");
    if (mysqli_fetch_assoc($check_user)) {
        echo "
        <script>
        alert('username sudah terdaftar');
        </script>
        ";
        return false;
    }
    if ($password !== $password2) {
        echo "
        <script>
        alert('konfirmasi password tidak sesuai');
        </script>
        ";
        return false;
    }
    $check_device_code = mysqli_query($conn, "SELECT KODE_PERANGKAT, ID_MASTER FROM `device_smart_knock_lock` WHERE KODE_PERANGKAT='$device_code'");

    $result = mysqli_fetch_assoc($check_device_code);
    if ($result) {
        if (is_null($result['ID_MASTER'])) {
            //enkripsi password
            $password = password_hash($password, PASSWORD_DEFAULT);

            mysqli_query($conn, "INSERT INTO `master` VALUES('', '$mail', '$username', '$password')");
            mysqli_query($conn, "UPDATE `device_smart_knock_lock` SET ID_MASTER =(SELECT ID_MASTER FROM `master` WHERE EMAIL='$mail') WHERE KODE_PERANGKAT='$device_code'");
            return mysqli_affected_rows($conn);
        } else {
            echo "
            <script>
                alert('device sudah terdaftar');
            </script>
        ";
        }
    } else {
        echo "
        <script>
        alert('kode device smart knock lock invalid');
        </script>
        ";
        return false;
    }

    return false;
}

function tampil($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);

    $rows = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function upload()
{
    $namaFile = $_FILES['profile']['name'];
    $ukuranFile = $_FILES['profile']['size'];
    $errorFile = $_FILES['profile']['error'];
    $tempFile = $_FILES['profile']['tmp_name'];

    //cek apakah ada foto yg dikirim
    if ($errorFile == 4) {
        echo "
            <script>
                alert('WAJIB MEMASUKKAN FOTO');
            </script>
        ";
        return false;
    }

    // cek apakah yang dikirim user adalah gambar 
    $extensiData = ['jpg', 'png', 'jpeg', 'jfif', 'gif'];
    $ekstensiGambar = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    if (!in_array($ekstensiGambar, $extensiData)) {
        echo "
            <script>
                alert('ANDA TIDAK MEMASUKKAN FOTO');
            </script>
        ";
        return false;
    }

    //cek ukuran file lebih besar dari batasan
    if ($ukuranFile > 100000) {
        echo "
            <script>
                alert('UKURAN FILE TERLALU BESAR!');
            </script>
        ";
        return false;
    }

    //lolos pengecekan
    //gegnerate nama file baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tempFile, 'img/' . $namaFileBaru);
    return $namaFileBaru;
}
