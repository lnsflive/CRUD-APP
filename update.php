<?php
//session start
if (!isset($_SESSION)) {
    session_start();
}

//connect db
require_once('mysqli/mysqli_connect.php');

$id = $_POST['id'];
$user_name = $_SESSION['username'];
$accession = $_POST['accession'];
$mrn = $_POST['mrn'];
$pName = $_POST['pName'];
$pDOB = $_POST['pDOB'];
$pDOS = $_POST['pDOS'];
$doctor = $_POST['doctor'];
$description = $_POST['description'];

//$sql = "UPDATE discrepancies SET accession='$accession',mrn='$mrn',pName='$pName',pDOB='$pDOB',pDOS='$pDOS',doctor='$doctor',description='$description' WHERE id=$id";
$sql = "INSERT INTO discrepancies (id,user,accession,mrn,pName,pDOB,pDOS,doctor,description) VALUES ('$id','$user_name','$accession','$mrn','$pName','$pDOB','$pDOS','$doctor','$description')";

if (mysqli_query($mysqli, $sql)) {
    echo json_encode(array("statusCode" => 200, "last_insert_id" => $mysqli->insert_id));
} else {
    echo json_encode(array("statusCode" => 201, "id" => $id, "username" => $user_name, "accession" => $accession, "mrn" => $mrn, "pName" => $pName, "pDOB" => $pDOB, "pDOS" => $pDOS, "doctor" => $doctor, "description" => $description));
}
mysqli_close($mysqli);


