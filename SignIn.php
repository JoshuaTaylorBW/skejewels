<?php


	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "skejewel";
	session_start();

	$con=new mysqli($servername,$username,$password, $dbname);
	if($con->connect_error){
		die("connection failed " . $con->connect_error);
	}


include 'functions.php';

mysqli_select_db($con, "skejewel");

$ID = $_POST['username'];
$Password = $_POST['password'];
if(isset($_POST['RememberMe'])){
	$rememberMe = $_POST['RememberMe'];
}else{
	$rememberMe = 'no';
}

	session_start();

	$logged = 0;
	if(!empty($_POST['username'])){

		//echo'<script>window.location = "index.php";</script>';

		$query = mysqli_query($con, "SELECT * FROM users WHERE Nickname = '$_POST[username]'") or die(header('Location: index.php'));
		while($row = mysqli_fetch_assoc($query)){
			$db_password = md5($row['Password']);
			if((md5($Password) == $row['Password']) || password_verify($Password, $row['Password'])){
				$logged++;
				$loginOk = TRUE;
			}else{
				$loginOk = FALSE;
			}
			if($loginOk){

				if($rememberMe == "on"){
					setcookie("cookies[UserId]", $row['id'], time()+31536000);
					setcookie("cookies[Nickname]", $row['Nickname'], time()+31536000);
					setcookie("cookies[FirstNames]", $row['UserFirstName'], time()+31536000);
					setcookie("cookies[LastNames]", $row['UserLastName'], time()+31536000);
					setcookie("cookies[Friends]", $row['Friends'], time()+31536000);
					//createVariables();
				}
					$_SESSION['Username'] = $row['Password'];
					$_SESSION['UserId'] = $row['id'];
					$_SESSION['Nickname'] = $row['Nickname'];
					$_SESSION['FirstNames'] = $row['UserFirstName'];
					$_SESSION['LastNames'] = $row['UserLastName'];
					$_SESSION['Friends']=$row['Friends'];
					header('Location: NewMain.php');
				 // exit();

			}else{

				header('Location: index.php');
				echo "<p> Wrong username or password </p>";
			}
		}
	}
	if($logged == 0){
		header('Location: index.php');
	}
 ?>
