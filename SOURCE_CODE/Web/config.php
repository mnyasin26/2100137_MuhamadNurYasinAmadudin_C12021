<?php
$host = "localhost";
$username = "root";
$password = "";
$db = "esp32_test";

$conn = mysqli_connect($host, $username, $password, $db);

if ($conn) {
    //echo "Connection established";
} else {
    die("Connection failed");
}
