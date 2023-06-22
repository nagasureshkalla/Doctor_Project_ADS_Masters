<?php
session_start();
header('Content-Type: application/json');
$conn="";
require 'pdo.php';

$sql="INSERT INTO appointments (doctor_uid, patient_uid, time_appointment, date_appointment) VALUES (:doctor_uid,:patient_uid, :time_appointment, :date_appointment)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':doctor_uid',$_GET['doctor_uid']);
            $stmt->bindParam(':patient_uid', $_SESSION["uid"]);
            $stmt->bindParam(':time_appointment', $_GET['time_slots']);
            $stmt->bindParam(':date_appointment', $_GET['slotdate']);
           
            $stmt->execute();
            $_SESSION["success"]="Slot Booked Successfully";
header("Location:doctor.php");
return;
?>