
<!-- https://codepen.io/FlorinPop17/pen/vPKWjd -->
<?php

session_start();

?>
<html>
	<head>
		<link rel="stylesheet" href="index.css">
	</head>
<body>
		<div>
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
		</div>
<div class="container" id="container">
	
	
	<div class="form-container sign-up-container">
		<form action="signup.php" method="post">
			<h1>Create Account</h1>
			<input name="signup_name" type="text" placeholder="Name" oninvalid="this.setCustomValidity('Enter Your Name Here')" oninput="this.setCustomValidity('')" required/>
			<input name="signup_email" type="email" placeholder="Email" oninvalid="this.setCustomValidity('Enter Your Email Here')" oninput="this.setCustomValidity('')" required/>
			<input name="signup_pass" type="password" placeholder="Password" oninvalid="this.setCustomValidity('Enter Your Password Here')" oninput="this.setCustomValidity('')" required/>
			
				
			<br><input type="checkbox" id="is_doctor" name="is_doctor" value="0" onclick="ShowHideDiv(this)"><label for="is_doctor">Is Doctor</label>
			
			<script type="text/javascript">
				function ShowHideDiv(chkPassport) {
					var dvPassport = document.getElementById("signup_hospital_name");
					dvPassport.style.display = chkPassport.checked ? "block" : "none";
					if(chkPassport.checked){
						document.getElementById("is_doctor").value=1;
					}
					else{
						document.getElementById("is_doctor").value=0;
					}
				}
			</script>
			
			<input id="signup_hospital_name" style="display: none;" name="signup_hospital_name" type="text" placeholder="Hospital Name" value="" />

			<button>Sign Up</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		
		<form action="login.php" method="post">
			<h1>Sign in</h1>
			<input name="signin_email" type="email" placeholder="Email" oninvalid="this.setCustomValidity('Enter Your Email Here')" oninput="this.setCustomValidity('')" required/>
			<input name="signin_pass" type="password" placeholder="Password" oninvalid="this.setCustomValidity('Enter Your Password Here')" oninput="this.setCustomValidity('')" required/>
			<button>Sign In</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start with us</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>


<script>
	const signUpButton = document.getElementById('signUp');
	const signInButton = document.getElementById('signIn');
	const container = document.getElementById('container');

	signUpButton.addEventListener('click', () => {
		container.classList.add("right-panel-active");
		document.getElementById('message').innerHTML ="";
	});

	signInButton.addEventListener('click', () => {
		container.classList.remove("right-panel-active");
		document.getElementById('message').innerHTML ="";
	});

</script>
</body>
</html>