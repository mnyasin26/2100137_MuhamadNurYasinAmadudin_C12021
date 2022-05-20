<?php

error_reporting(E_ERROR | E_PARSE);
$host = "localhost";
$user = "root";
$pass = "";
$db = "esp32_test";

define('DBPATH', $host);
define('DBUSER', $user);
define('DBPASS', $pass);
define('DBNAME', $db);

$mysqli = new mysqli($host, $user, $pass, $db);

// Check connection
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}

$nama       = $_POST['nama'];
$jurusan    = $_POST['jurusan'];

$insert = mysqli_query($connect, "insert into mahasiswa set nama='$nama', jurusan='$jurusan'");

?>