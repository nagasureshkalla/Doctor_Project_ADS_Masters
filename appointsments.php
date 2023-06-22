<?php
session_start();

    if(!isset($_SESSION["uid"])){
        header("Location:index.php");
        return;
    }


   

function getallAppointments(){
    
    $conn="";
    require 'pdo.php';
    $stmt = $conn->prepare("SELECT * FROM appointments where patient_uid=? or doctor_uid=? order by date_appointment DESC");
    $stmt->execute([$_SESSION["uid"],$_SESSION["uid"]]);
    $user = $stmt->fetchAll();
    foreach($user as $x ) {
        echo "<div class='box-shadow' onclick='startintervalcall(".$x["appointment_id"].")'>";
            echo "<div class='container center'>";
            if(date('Y-m-d')>$x["date_appointment"]){
                echo " <p style='color:red'>Expired</p>";
            }
            elseif(date('Y-m-d')<=$x["date_appointment"]){
                echo " <p style='color:green'>Upcoming</p>";
            }
            echo " <p style='color:black'>Date of Appointment : ".$x["date_appointment"]."</p>";
            $stmt = $conn->prepare("SELECT * FROM users where uid=?");
            $stmt->execute([$x["doctor_uid"]]);
            $doctor = $stmt->fetch();
            echo "<p style='color:black'>Doctor Name : ".$doctor["name"]."</p>";
            echo "<p style='color:black'>Hospital Name : ".$doctor["hospital_name"]."</p>";
            echo "<p style='color:black'>Time of Appointment : ".$x["time_appointment"]."</p>";
            echo "</div>";
        echo "</div>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors</title>
    <script src="https://unpkg.com/@trevoreyre/autocomplete-js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<link
  rel="stylesheet"
  href="https://unpkg.com/@trevoreyre/autocomplete-js/dist/style.css"/>
     
  <link rel="stylesheet" href="doctor.css"> 
 
</head>
<body>
    <div>
    <header></header>
        <script>

                


                fetch("topbar.html")
                .then(response => {
                    return response.text()
                })
                .then(data => {
                    document.querySelector("header").innerHTML = data;
                });
        </script>
   
   <div class="row">
    <div class="column">
    <?php
        getallAppointments();
    ?>
    </div>
    <div class="column">
        
        <div style="display: none;" id="chatdiv">
                <div  style="overflow-y:auto" id="chatmessages"></div>

                <br>
                <!-- <form method = "get" id="chatform" action="chatmessagepost.php" > -->
                    <input class="input" type='text' id='chatmessage' name='chatmessage'  minlength='2' placeholder="Write your message" required>
                    <button onclick="chatmessagepost()">Send</button>
                <!-- </form> -->
        </div>
    </div>
   </div>
        
    </div>

    <script>


        var $ =(id)=> document.getElementById(id);

    

        let nIntervId;
        function startintervalcall(appointment) {
            stopTimer();
        // check if an interval has already been set up
            if (!nIntervId) {
                $("chatdiv").style.display="";
                nIntervId = setInterval(function() {getchatMessages_print(appointment)}, 1000); 
            }
        }
        function getchatMessages_print(appointment) {

                    console.log("At Log: getchatMessages_print "+appointment);



                    fetch('chatmessages.php?appointment_id='+appointment, { method: 'GET' })
                    .then(Result => Result.json())
                    .then(string => {
        
                        // Printing our response 
                        // console.log(string);
                        var messages="";
                        if(string.length > 0){
                        for (let i = 0; i < string.length; i++) { 

                            console.log( string[i]["message"] );
                            if (string[i]["sendby"]!=<?php echo $_SESSION['uid'] ?>){
                                messages+="<p  style='text-align:left;color:black;background-color:grey;width:125px;border-radius: 25px;border: 2px solid #000000;padding: 5px;'>"+string[i]["message"]+"</p>";
                            }else{
                                messages+="<p  style='text-align:right;color:black;'>"+string[i]["message"]+"</p>";
                            }

                        }
                        }
                        var text="<div class='box-shadow' style='max-width: -150px;'>";
                        var textend="</div>";

                        $("chatmessages").innerHTML=text+messages+textend;
                    })
                    .catch(errorMsg => { console.log("At error Block in Appointments chat: "+errorMsg); });
            }

        function stopTimer() {
            clearInterval(nIntervId);
            // release our intervalID from the variable
            nIntervId = null;
        }


        function chatmessagepost(){
            var message=$("chatmessage").value;
            if(message.length>=2){
                fetch('chatmessagepost.php?chatmessage='+message, { method: 'GET' })
                    .then(Result => Result.json())
                    .then(string => {
                        console.log(message);
                    })
                    .catch(errorMsg => { console.log("At error Block in Appointments chat: "+errorMsg); });
            }
            $("chatmessage").value="";
        }
    </script> 
    <!-- <?php

        if(isset($_SESSION["messagepost"]) && $_SESSION["messagepost"]==1){
            echo "<script type='text/javascript'>startintervalcall(".$_SESSION["appointment_id"].");</script>";
        }
    ?> -->
</body>
</html>