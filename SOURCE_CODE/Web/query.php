<?php
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: ./index.php");
    exit;
}

include './config.php';

if (isset($_POST['tambah'])) {
    $id_akun = $_POST['fid_akun'];
    $judul = $_POST['fjudul'];
    $kategori = $_POST['fkategori'];
    $penulis = $_POST['fpenulis'];
    $tahun = $_POST['ftahun'];

    if (is_uploaded_file($_FILES['ffile']['tmp_name'])) {
        date_default_timezone_set("Asia/Jakarta");
        $tgl = date("Ymd"); // ambil informasi dari file yang diupload
        $tmp_file = $_FILES['ffile']['tmp_name'];
        $nm_file = $_FILES['ffile']['name'];
        $ukuran_file = $_FILES['ffile']['size'];
        // $desc = $_POST['desc'];
        $ext = pathinfo($nm_file, PATHINFO_EXTENSION);

        $size = 10000000; // limit 10 MB

        if ($ukuran_file > $size) {
            echo "<strong>Gagal upload! <br>Ukuran Maksimal 10MB, saat ini ukuran file " . $ukuran_file . "</strong>";
            echo "<a href='index.php'>Upload ulang</a>";
            exit();
        } else {
            if ($nm_file) {
                $sql =
                    'INSERT INTO t_databuku VALUES ("", "' . $judul . '", "' . $kategori . '", "' . $penulis . '", "' . $tahun . '", "' . $nm_file . '", ' . $id_akun . ')';
                $query = mysqli_query($conn, $sql);

                if ($query) {
                    // alamat direktori yang digunakan untuk menyimpan hasil upload

                    
                    $dir = "file/$nm_file";
                    move_uploaded_file($tmp_file, $dir);

                    echo "<strong>$nm_file</strong> berhasil di upload!";
                    echo "<br>";
                    echo "<a href='home.php'>Lihat Data</a>";
                } else {
                    die("Invalid query: " . mysqli_error($conn));
                }
            } else {
                echo "Gagal upload!";
                echo "<br>";
                echo "<a href='form_upload.php'>Upload ulang</a>";
            }
        }
    }
    else
    {
        $sql = 'INSERT INTO t_databuku VALUES ("", "' . $judul . '", "' . $kategori . '", "' . $penulis . '", "' . $tahun . '", "dummy.jpg", ' . $id_akun . ')';

        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<p>Data berhasil ditambahkan</p>";
            echo "<p><a href='./index.php'>Kembali ke tampilan utama</a></p>";
            header('location: index.php');
        } else {
            die("Invalid query" . mysqli_error($conn));
        }
    }
}

if (isset($_POST['edit'])) {
    $id_buku = $_POST['id_buku'];
    $judul = $_POST['fjudul'];
    $kategori = $_POST['fkategori'];
    $penulis = $_POST['fpenulis'];
    $tahun = $_POST['ftahun'];

    $sql = 'UPDATE t_databuku SET judul_buku="' . $judul . '", kategori_buku="' . $kategori . '", nama_penulis="' . $penulis . '", tahun_terbit="' . $tahun . '" WHERE id_databuku=' . $id_buku;

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<p>Data berhasil diupdate</p>";
        echo "<p><a href='./index.php'>Kembali ke tampilan utama</a></p>";
        header('location: index.php');
    } else {
        die("Invalid query" . mysqli_error($conn));
    }
}

if (isset($_POST['hapus'])) {
    $id = $_POST['id_databuku'];

    $sql = 'DELETE FROM t_databuku WHERE id_databuku=' . $id;

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<p>Data berhasil dihapus</p>";
        echo "<p><a href='./index.php'>Kembali ke tampilan utama</a></p>";
        header('location: index.php');
    } else {
        die("Invalid query" . mysqli_error($conn));
    }
}
