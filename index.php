<!DOCTYPE html>
<html>
<head>

<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
	 <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
	 <link rel="stylesheet" href="BannerStyle.css">
	<link rel="stylesheet" type="text/css" href="LoginStyle.css">
		<link rel="icon" type="image/png" href="imgs/Favicon.png">

	<title>Skejewels</title>

<div id="BarBanner">
	<a id="jewel">
		<img src="Jewel.png"  height="85%" border="0">
	</a>
</div>

<div id="background-wrap">
<div id="bg">

<img src="Background/Real.png" alt="">

</div>
</div>

<div id="Message">
	<h1 id="MessageTitle">Skejewels</h1>
	<h2 id="MessageContents">are social calendars <br>that allow  you to stay connected<br> to your friends by seeing each other's <br>plans and schedules. <br>they are the calendar sharing resource.</h2>
</div>

</head>

	<body onload="hideButton()">

	<script>
		function hideButton () {
			$('#LoginButton2').hide();

			if(window.XMLHttpRequest){
				xmlhttp = new XMLHttpRequest();
			}else{
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					if(xmlhttp.responseText == "Go"){
						window.location = "NewMain.php";


					}else{
					}
				}
			}
			xmlhttp.open("GET","CheckLoggedIn.php", true);

			xmlhttp.send();
		}

			$(document).ready(function(){
				$('#usernameBox2').keyup(username_check);
				$('#passBox2').keyup(username_check);
				$('#FirstNameBox').keyup(username_check);
				$('#LastNameBox').keyup(username_check);
				$('#EmailBox2').keyup(username_check);
			});

			function username_check () {

				if(window.XMLHttpRequest){
					xmlhttp = new XMLHttpRequest();
				}else{
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				var firstname = $('#FirstNameBox').val();
				var lastname = $('#LastNameBox').val();
				var email = $('#EmailBox2').val();
				var username = $('#usernameBox2').val();
				var password = $('#passBox2').val();

				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

						if(username == "" || username.length < 4){
							$('#usernameBox2').css('border', '1px #a1a1a1 solid');
						}else{
							if(xmlhttp.responseText == 1){
								$('#usernameBox2').css('border', '3px #C33 solid');
							}else{
								$('#usernameBox2').css('border', '3px #090 solid');
								if((firstname == "" || firstname.length < 4) ||
									(lastname == "" || lastname.length < 4) ||
									(email == "" || email.length < 5) ||
									(username == "" || username.length < 3) ||
									(password == "" || password.length < 5))
									{
									$('#LoginButton2').fadeOut();
								}else{
									$('#LoginButton2').fadeIn();
								}
							}
						}
					}
				}



				xmlhttp.open("GET","NicknameAvailability.php?nickname="+username, true);

				xmlhttp.send();

			}


			function Register () {
				if(window.XMLHttpRequest){
					xmlhttp = new XMLHttpRequest();
				}else{
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}

				var firstname = document.getElementById("FirstNameBox").value;
				var lastname = document.getElementById('LastNameBox').value;
				var email = document.getElementById('EmailBox2').value;
				var username = document.getElementById('usernameBox2').value;
				var password = document.getElementById('passBox2').value;

				xmlhttp.onreadystatechange = function() {
					if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					}
				}
					xmlhttp.open("GET","Register.php?FirstName="+firstname+"&LastName="+lastname+
						"&Email2="+email+"&Username2="+username+"&password="+password, true);

					xmlhttp.send();
			}
	</script>

		<a href="index.php" id="jewel2">
			<img src="Jewel.png" width="111" height="99" border="0">
		</a>

		<img id="check" src="available.png" width="16"height="16">
		<img id="cross" src="not-available.png" width="16" height="16">

		<div id="wrappert">
			<div id="verticality">
				<div id="loginBox" >
				</div>
			</div>
		</div>
		<div id="Login">
			<form method="POST" action="SignIn.php">
				Username: <input type="text" name="username" id="usernameBox" placeholder="Nickname"><br>
				Password: <input type="password" name="password"id="passBox" placeholder="Password">
				<input type="submit" name="SubmitButton" id="LoginButton" value="Log In" onclick="SignIn.php"><br>
				<input type="checkbox" name="RememberMe" id="RememberMe">
				<span id="rememberText">Remember Me</span>
			</form>
		</div>


		<div id="Register">
			<p id="SignUpText">Sign up for Skejewels</p>
		</div>



		<form method="POST" action="Register.php" id="RegisterForm" onkeypress="return event.keyCode != 13;">
			First Name: <input type="text" name="firstName" id="FirstNameBox" placeholder="First Name"><br>
			Last Name: <input type="text" name="LastName" id="LastNameBox" placeholder="Last Name"><br>
			Username: <input type="text" name="Email2" id="EmailBox2" placeholder="Email"><br>
			E-Mail: <input type="text" name="Username2" id="usernameBox2" placeholder="Nickname: @..."><br>
			Password: <input type="password" name="password"id="passBox2" placeholder="Password">
			<span id="user-result"></span>
			<input type="submit" name="SubmitButton" id="LoginButton2" value="Sign up for Skejewels" onclick="Register();"><br>
		</form>


		<p id="Terms">By clicking the "Sign up for Skejewels" button, you are agreeing to our <a href="Terms.php">Terms of Service</a> </p>

	</body>
</html>
