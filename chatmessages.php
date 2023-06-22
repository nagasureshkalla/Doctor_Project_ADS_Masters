<?php
session_start();
header('Content-Type: application/json');
$conn="";
require 'pdo.php';

$_SESSION["appointment_id"]=$_GET["appointment_id"];

$stmt = $conn->prepare("SELECT * FROM appointmentchat where appointment_id=? order by date_of_message,time_of_message ASC");
$stmt->execute([$_GET["appointment_id"]]);
$user = $stmt->fetchAll();


echo json_encode($user);
?>