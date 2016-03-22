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

$id = $_GET['id'];

$query = ("SELECT * FROM users WHERE id=$id")	OR DIE(mysqli_error());
$result = mysqli_query($con,$query);

$initialRequests = "";
$alreadyRequested = 0; //did you already request to be their friend?

while ($row = mysqli_fetch_array($result)) { //change current users friends list
	$initialRequests = $row['RequestsFrom'];
	$indivs = explode(',', $initialRequests);
	for ($i=0; $i < count($indivs); $i++) { 
		if($indivs[$i] == intval($_SESSION["UserId"])){
			$alreadyRequested++;
		}
	}
}

if($alreadyRequested === 0){
$insert = "UPDATE users SET NewFriends = NewFriends + 1, RequestsFrom = 
		CONCAT_WS(',','" . $_SESSION["UserId"] . "', '" . $initialRequests . "')
			WHERE id='$id'";
mysqli_query($con, $insert);
}
 ?>
