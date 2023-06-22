<?php
    session_start();

    $conn="";
    require "pdo.php";
        
    echo $_POST["signup_pass"]." ".$_POST["signup_name"]." ".$_POST["signup_email"];    
    if (isset($_POST['signup_name']) && isset($_POST['signup_email']) && isset($_POST["signup_pass"])){ // check if all values are present for signup

        $name = $_POST['signup_name'];
        $email = $_POST['signup_email'];
        $pass = $_POST["signup_pass"];
        $is_doctor=is_null($_POST['is_doctor'])?0:$_POST['is_doctor'];
        $is_active=0;
        $hospital_name=$_POST['signup_hospital_name'];
        echo $name." ".$email." ".$pass." ".$hospital_name;


        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->execute([$email]); 
        $user = $stmt->fetch();
        if(isset($user["email"] )){
          session_unset();
          $_SESSION["error"] = "User already exists";
          header("Location:index.php");
          return;
        }
        else{
            $hash = password_hash($pass, PASSWORD_DEFAULT);

            $sql="INSERT INTO users (name, email, password, is_doctor, is_active, hospital_name) VALUES (:name, :email, :password, :is_doctor, :is_active, :hospital_name)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hash);
            $stmt->bindParam(':is_doctor', $is_doctor);
            $stmt->bindParam(':is_active', $is_active);
            $stmt->bindParam(':hospital_name', $hospital_name);
            $stmt->execute();
            session_unset();
            $_SESSION["success"] = "User successfully created";
            header("Location:index.php");
            return;
           
        }
    }
    
?>

