<?php
session_start();
header('Content-Type: application/json');
$conn="";
require 'pdo.php';
$datee=date('Y-m-d');
$timee=date("h:i:s");
$sql="INSERT INTO appointmentchat (appointment_id, sendby, message, time_of_message,date_of_message) VALUES (:appointment_id,:sendby, :message, :time_of_message, :date_of_message)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':appointment_id',$_SESSION['appointment_id']);
$stmt->bindParam(':sendby', $_SESSION["uid"]);
$stmt->bindParam(':message', $_GET['chatmessage']);
$stmt->bindParam(':time_of_message', $timee);
$stmt->bindParam(':date_of_message', $datee);
$stmt->execute();


// $stmt = $conn->prepare("SELECT * FROM appointmentchat where appointment_id=? order by date_of_message,time_of_message ASC");
// $stmt->execute([$_SESSION["appointment_id"]]);
// $user = $stmt->fetchAll();
// echo json_encode('{}');
// $_SESSION["messagepost"]="1";
header("Location:appointsments.php");
return;

?>