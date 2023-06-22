<?php
header('Content-Type: application/json');
$conn="";
require 'pdo.php';
$stmt = $conn->prepare("SELECT * FROM users WHERE is_doctor=1 AND (name LIKE '%".$_GET['name']."%' OR hospital_name LIKE '%".$_GET['name']."%')");
$stmt->execute(); 
$user = $stmt->fetchAll();
echo json_encode($user);
?>