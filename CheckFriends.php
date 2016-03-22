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

$id = $_GET["id"]; // friends id
$currUserId = $_SESSION["UserId"];


$query = ("SELECT * FROM users WHERE id='$currUserId'")	OR DIE(mysqli_error());
$result = mysqli_query($con,$query);
$say = ":";
$moved = False;
while($row = mysqli_fetch_array($result)){
	$friends = explode(",", $row['Friends']);

	
	
	for ($i=0; $i <= count($friends); $i++) { 
		$query2 = ("SELECT * FROM users WHERE id=$id")	OR DIE(mysqli_error());
			$result2 = mysqli_query($con,$query2);
			$name = "";
			while($row = mysqli_fetch_array($result2)){
				$name = $row['UserFirstName'];
			}
		if(intval($id) === intval($friends[$i])){

			header( 'Location: FriendsCalendar.php?id=' . $id .'_' . $name);
			$moved = True;
		}else{
			if ($i === count($friends)) {
				if(!$moved){
				header( 'Location: CheckRequests.php?id='.$id .'_' . $name);
				}
			}
		}
	}
}

 ?>