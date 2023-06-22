<?php
session_start();

    if(!isset($_SESSION['uid'])){
        header("Location:login.php");
        return;
    }

    function listofDoctors($user) {
        if(count($user)>0){
            foreach($user as $x ) {
                echo "<div class='box-shadow' onclick='divcall(".json_encode($x).")'>";
                    echo "<div class='container center'>";
                    $color="red";
                    $text="Offline";
                    if($x["is_active"]==1){
                        $color="green";
                        $text="Online";
                    }
                    echo " <p style='color:black'>Doctor Name : ".$x["name"]."</p><p style='background-color:".$color.";width:50px'>".$text."</p>";
                    echo "<p style='color:black'> Hospital Name: ".$x["hospital_name"]."</p>";
                    echo "</div>";
                echo "</div>";
            }
        }
        else{
            echo "<p>No Doctors Found</p><br>";
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

    <div id="autocomplete" class="autocomplete" style="width:50%">
      <input class="autocomplete-input" onfocus="this.value=''" placeholder="Search for Doctor or Hospital"  />
      <ul class="autocomplete-result-list"></ul>
    </div>

            <?php
                $conn="";
                require "pdo.php";
                $stmt = $conn->prepare("SELECT * FROM users where is_doctor=1");
                $stmt->execute(); 
                $user = $stmt->fetchAll();

                // $uid_of_doctor=array();
                // foreach($user as $x ) {
                //     array_push($uid_of_doctor,$x["uid"]);
                // }
                // $query = "SELECT * FROM doctor_details Where uid IN ( '" . implode( "', '", $uid_of_doctor ) . "' )";
                // $stmt = $conn->prepare($query);
                // $stmt->execute(); 
                // $doctors = $stmt->fetchAll();
                listofDoctors($user);
            ?> 
    </div>

    <div class="column">
    <?php
				if(isset($_SESSION["error"])){
					echo "<p id='message' style='color:red'>".$_SESSION["error"]."</p>";
			$_SESSION["error"]="";
				}
				else if(isset($_SESSION["success"])){
					echo "<p id='message' style='color:green'>".$_SESSION["success"]."</p>";
			$_SESSION["success"]="";
				}
			?>
        <div id="slot_div">
                 

        </div>
        <!-- <p style="color:green;">No Payment, Free of cost..</p> -->
    </div>


    </div>
    </div>
    
    


    <script> // Search Bar script


    var $ =(id)=> document.getElementById(id);

    new Autocomplete('#autocomplete', {

      search : input =>{
        // console.log(input)
        const url=`searchdoctors.php/?name=${input}`
        return new Promise(resolve =>{
          fetch(url)
          .then(response => response.json())
          .then(data =>{
            // console.log(data)
            resolve(data)
          })
        })
      },

      renderResult: (result, props) => `
        <li ${props}>
        <div class="name">
            ${result.name}
        </div>
        <div class="hospital_name">
            ${result.hospital_name}
        </div>
        </li>
        `,

        getResultValue: result => result.name,

      onSubmit: result=> {
        divcall(result);
      }, 
      autoSelect: true
    })

   


    function timechange(time,uid){

          // +"&date_appointment="+document.getElementById("slotdate").value+"&time_appointment="+time.value
          console.log("Time "+time.value);

         if(time.value!="Please Select Time"){

          fetch('timeslots.php?uid='+uid+"&date_appointment="+document.getElementById("slotdate").value+"&time_appointment="+time.value, { method: 'GET' })
        .then(Result => Result.json())
        .then(string => {
  
            // Printing our response 
            console.log(string);

            const json_string= JSON.parse(string);
              
            // Printing our field of our response
            console.log(json_string.text);
            $("label").innerHTML = json_string.text;
            $("label").style.color= json_string.color;
            if(json_string.color=='green'){
              $("bookslotbutton").style.visibility='';
            }
            else{
              $("bookslotbutton").style.visibility='hidden';
            }
        })
        .catch(errorMsg => { console.log("At error Block : "+errorMsg); });
      }
      else{
        $("bookslotbutton").style.visibility='hidden';
        $("label").innerHTML="";
      }

    }


    // book appointments page functionality
    function divcall(uid){
        // alert("Hello! I am an alert box!!  "+uid);
        console.log("At divcall");
        console.log(uid);

        var startdiv="<br><br><br><br><div> <div> Doctor Name: <p id='doctor_name'>"+uid.name+"</p><br>Hospital Name: <p id='hospital_name'>"+uid.hospital_name+"</p><br> <p id='specality'></p><br></div>";
        var form="<form method='get' action='bookslot.php'><input type='text' style='display:none' name='doctor_uid' id='doctor_uid' value='"+uid.uid+"'/>Slot Date: <input type='date' name='slotdate' min='<?php echo date('Y-m-d');?>' id='slotdate' onchange='changetodefaultdropdown()'  value='<?php echo date('Y-m-d');?>'  required />";
        var time="<br>Time of Slot: <select name='time_slots' id='time_slots' onchange='timechange(this,"+uid.uid+")'><option value='Please Select Time'>Please Select Time</option>\
        <option value='6.00'>6.00</option>\
        <option value='6.30'>6.30</option>\
        <option value='7.00'>7.00</option>\
        <option value='7.30'>7.30</option>\
        <option value='8.00'>8.00</option>\
        <option value='8.30'>8.30</option>\
        <option value='9.00'>9.00</option>\
        <option value='9.30'>9.30</option>\
        <option value='10.00'>10.00</option>\
        <option value='10.30'>10.30</option>\
        <option value='11.00'>11.00</option>\
        </select><br><p id='label'></p><br><br><button style='visibility:hidden' id='bookslotbutton'>Book Slot</button></form>";


        var closediv="</div>";

       
        document.getElementById("slot_div").innerHTML = startdiv+form+time+closediv;

        // $.getJSON("timeslots.php?uid="+uid+"&date_appointment="+document.getElementById("slotdate").value+"&time_appointment="+$("time_slots").value+"",function(result){
        //             result = JSON.parse(result);
        //             console.log(result);
        //             $("label").text(result.text);
        //             // $("label").css("color",result.color);  
        //   });   
              
        
    }

    function changetodefaultdropdown(){
        $('time_slots').selectedIndex=0;

        $("bookslotbutton").style.visibility='hidden';
        $("label").innerHTML="";
    }

    function dateset(){

        const date = new Date();
        let day = date.getDate().padStart(2, '0');
        let month = date.getMonth() + 1;
        let year = date.getFullYear();
        let currentDate = `${year}-${month}-${day}`;
        console.log(currentDate); 
        console.log(day);
        document.getElementById("slotdate").defaultValue = currentDate;
        document.getElementById("slotdate").min = currentDate;
    }




  </script>
  
 

 

</body>
</html>