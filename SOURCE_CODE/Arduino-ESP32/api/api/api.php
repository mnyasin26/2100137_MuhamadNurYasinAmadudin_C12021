<?php
include('./gmail.php');

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

$data = json_decode(file_get_contents('php://input'), true);

switch ($_GET['data']) {

	default:
		echo "<center><h1>NOT FOUND</h1></center>";
		break;
	case 'update_baterai':
		header('Content-Type: application/json');
		$id_master = $data['id_master'];
		$kapasitas_baterai = $data['kapasitas_baterai'];
		if ($id_master != '') {
			$sql = 'UPDATE device_smart_knock_lock SET KAPASITAS_BATERAI = ' . $kapasitas_baterai . ' WHERE ID_MASTER=' . $id_master;

			$result = mysqli_query($mysqli, $sql);
			if ($result) {
				echo '{"status":"success","message":"Data Added"}';
			} else {
				echo '{"status":"failed","message":' . mysqli_error($mysqli) . '}';
			}
		} else {
			echo '{"status":"failed","message":"Data Input is not complete"}';
		}
		break;

	case 'update_pola_kunci':
		header('Content-Type: application/json');
		$id_master = $data['id_master'];
		$pola_kunci = $data['pola_kunci'];
		if ($id_master != '') {
			$sql = 'UPDATE device_smart_knock_lock SET POLA_KUNCI = "' . $pola_kunci . '" WHERE ID_MASTER=' . $id_master;
			$result = mysqli_query($mysqli, $sql);
			if ($result) {
				echo '{"status":"success","message":"Data Added"}';
			} else {
				echo '{"status":"failed","message":' . mysqli_error($mysqli) . '}';
			}
		} else {
			echo '{"status":"failed","message":"Data Input is not complete"}';
		}
		break;

	case 'insert_riwayat':
		header('Content-Type: application/json');
		$id_perangkat = $data['id_perangkat'];
		$datetime = $data['datetime'];
		$state = $data['status']; // 2022-05-14 11:52:31.000000
		if ($id_perangkat != '') {
			$sql = 'INSERT INTO riwayat_brankas VALUES("", ' . $id_perangkat . ', "' . $datetime . '",' . $state . ')';
			$result = mysqli_query($mysqli, $sql);
			if ($result) {
				$emailResult = sendEmail($id_perangkat, $datetime, $state);
				echo '{"status":"success","message":"Data Added"}';
			} else {
				echo '{"status":"failed","message":' . mysqli_error($mysqli) . '}';
			}
		} else {
			echo '{"status":"failed","message":"Data Input is not complete"}';
		}
		break;
	case 'getall':
		header('Content-Type: application/json');
		$id_perangkat = 1;
		$sql = 'SELECT * FROM RIWAYAT_BRANKAS WHERE ID_PERANGKAT =' . $id_perangkat . ' ORDER BY RIWAYAT_BRANKAS DESC';
		$result = mysqli_query($mysqli, $sql);
		if ($result) {
			$emparray = array();
			while ($row = mysqli_fetch_assoc($result)) {
				$emparray['data'][] = $row;
			}
			echo  json_encode($emparray);
		} else {
			echo '{"status":"failed","message":' . mysqli_error($mysqli) . '}';
		}
		break;

	case 'realtime':
		header('Content-Type: application/json');
		$sql = 'SELECT * FROM device_smart_knock_lock';
		$result = mysqli_query($mysqli, $sql);
		if ($result) {
			$emparray = array();
			while ($row = mysqli_fetch_assoc($result)) {
				$emparray['data'][] = $row;
			}
			echo  json_encode($emparray);
		} else {
			echo '{"status":"failed","message":' . mysqli_error($mysqli) . '}';
		}
		break;

	case 'get_pressed':
		header('Content-Type: application/json');
		$id_perangkat = 1;
		$sql = 'SELECT IS_PRESSED FROM device_smart_knock_lock WHERE ID_PERANGKAT =' . $id_perangkat;
		$result = mysqli_query($mysqli, $sql);
		if ($result) {
			$emparray = array();
			while ($row = mysqli_fetch_assoc($result)) {
				$emparray['data'] = $row;
			}
			echo  json_encode($emparray);
		} else {
			echo '{"status":"failed","message":' . mysqli_error($mysqli) . '}';
		}
		break;
}

?>