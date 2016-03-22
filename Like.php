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

	$eventId = $_GET['eventId']; // the id of the event the user liked
	$eventName = $_GET['eventName'];
	$addEvent = $_SESSION['UserId'] . ",";
	$UserId = $_GET['UserId'];//other persons user id.

	$mostRecent = $_SESSION['UserId'] . " " . $_SESSION['FirstNames'] . " " . $_SESSION['LastNames'];

	$sql = "UPDATE events
		SET LikedIds = CONCAT(LikedIds, '$addEvent'),
		LikeAmount = LikeAmount+1, MostRecentLike = '$mostRecent' WHERE id='$eventId'" ; 

	mysqli_query($con, $sql);

	$splitVar = '?^--^?';
	$addVar = $addEvent . $_SESSION['FirstNames'] . " " . $_SESSION['LastNames']
	. ",    liked your event ," . $eventName . "," . $eventId . $splitVar; 

	$updateUsers = "UPDATE users
		SET Notifications = CONCAT('$addVar', Notifications), 
		NewNotifications = NewNotifications + 1 WHERE id='$UserId'";
	
	mysqli_query($con, $updateUsers) ;
	
 ?>