
<?php

session_start();

if(isset($_SESSION['uid'])){
  header('Location:doctor.php');
  return;
}
$conn="";
require "pdo.php";
if(isset($_POST['signin_email']) && isset($_POST["signin_pass"]) && $_POST["signin_email"]!="" && $_POST["signin_pass"]!=""){
    $email = $_POST['signin_email'];
    $pass = $_POST["signin_pass"];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]); 
    $user = $stmt->fetch();
    if($user["is_active"]){
        session_unset();
        $_SESSION["error"] = "User Already Logged in Another Browser";
        header("Location:index.php");
        return;
    }
    if(isset($user["email"] )){
      $verify = password_verify($pass, $user["password"]);
      echo $user["password"]." ".$verify;
      if ($verify) {
        session_unset();
        $_SESSION["success"] = "Login successfull";
        $_SESSION["uid"] = $user["uid"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["hospital_name"] = $user["hospital_name"];

        $updatestmt = $conn->prepare("UPDATE users SET is_active=1 WHERE email=?");
        $updatestmt->execute([$email]); 

        header("Location:doctor.php");
        return;
      } 
      else {
        session_unset();
        $_SESSION["error"] = "Password Incorrect";
        header("Location:index.php");
        return;
      }
    }
    else{
        session_unset();
        $_SESSION["error"] = "User Not Found";
        header("Location:index.php");
        return;
    }
}

?>

