<?php
$msg = "";
try {

    // if using Windows use 3306 as port, works
    // if using Macbook use 8888 as port
    $conn = new pdo('mysql:host=localhost;port=8888;dbname=doctor','php','phpdb');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    $msg = "Connection Err!";
}

?>