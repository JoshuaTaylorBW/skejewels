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

mysqli_select_db($con, "skejewel");

$FirstName = $_POST['firstName'];
$LastName = $_POST['LastName'];
$Email = $_POST['Email2'];
$Nickname = $_POST['Username2'];
$password = $_POST['password'];
$md5password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (Username, Password,
		Nickname, UserFirstName, UserLastName)
			VALUES ('$Email', '$md5password', '$Nickname', '$FirstName', '$LastName')";
	if ($con->query($sql) === TRUE) {
		$query = mysqli_query($con, "SELECT * FROM users WHERE Username = '$Email'");

		if(isset($Email)){

		while($row = mysqli_fetch_assoc($query)){

					$_SESSION['Username'] = $row['Password'];
					$_SESSION['UserId'] = $row['id'];
					$_SESSION['Nickname'] = $row['Nickname'];
					$_SESSION['FirstNames'] = $row['UserFirstName'];
					$_SESSION['LastNames'] = $row['UserLastName'];
					$_SESSION['Friends']=(string)$row['Friends'];

					header('Location: NewMain.php');
					exit();
					echo "successful!!";
				}

		}
	}else{
		echo "MEssed up" . $con->error;
	}

 ?>
