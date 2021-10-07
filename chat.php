<?php
//session start
if (!isset($_SESSION)) {
    session_start();
}

//connect db
require_once('mysqli/mysqli_connect.php');

$result = array();
$message = $_POST['message'];
$user_name = $_SESSION['username'];
$date = date('h:i:s a m/d/Y', time());


if (!empty($message) && !empty($user_name)) {
    $sql = "INSERT INTO chat (message,user,created) VALUES ('$message','$user_name','$date')";
    $result['send_status'] = mysqli_query($mysqli, $sql);
}

//print messages
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$items = mysqli_query($mysqli, "SELECT * FROM chat WHERE id > " . $start);
while ($row = mysqli_fetch_assoc($items)) {
    $result['items'][] = $row;
}



$mysqli->close();

header('Acces-Control-Allow-Origin: *');
header('Content-Type: application/json');

echo json_encode($result);
