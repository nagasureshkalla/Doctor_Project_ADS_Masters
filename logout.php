<?php

    session_start();

    $conn="";
    require "pdo.php";

    if(isset($_SESSION['uid'])){
      $updatestmt = $conn->prepare("UPDATE users SET is_active=0 WHERE uid=?");
      $updatestmt->execute([$_SESSION['uid']]); 
      session_unset();
      $_SESSION["success"] = "Logout Success";
      header('Location:index.php');
      return;
    }
    
?>