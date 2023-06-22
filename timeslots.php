<?php
header('Content-Type: application/json');
$conn="";
require "pdo.php";
$responce='{"error":1}';
$stmt = $conn->prepare("SELECT * FROM appointments where doctor_uid=? and date_appointment=? and time_appointment=?");
$stmt->execute([$_GET["uid"],$_GET["date_appointment"],$_GET["time_appointment"]]); 
$user = $stmt->fetchAll();
// // print_r($user);


if(sizeof($user)>0){
    $responce='{"error":"1","color":"red","text":"Doctor is Not Available at '.$_GET['time_appointment'].' on date '.$_GET['date_appointment'].'"}';
}
else{
    $responce='{"error":"0","color":"green","text":"Doctor is Available at '.$_GET['time_appointment'].' on date '.$_GET['date_appointment'].'"}';

}

echo json_encode($responce);
// return json_encode($responce);
       
?>