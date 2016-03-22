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

		$currUserId = "";
		$currUserId .= $_SESSION["UserId"];

$query = ("SELECT * FROM users WHERE id='$currUserId'") OR DIE(mysqli_error());
$result = mysqli_query($con, $query);

while($row = mysqli_fetch_array($result)){
	if(intval($row['NewNotifications']) > 0){
		echo "<div id='notificationsAmountContainer'>";
		echo "<span id='notificationAmountText'> " . $row['NewNotifications'] . "</div>";
		echo "</div>";
	}
	if(intval($row['NewFriends']) > 0){
		echo "<div id='requestsAmountContainer'>";
		echo "<span id='requestsAmountText'> " . $row['NewFriends'] . "</div>";
		echo "</div>";
	}
   	echo $_SESSION['UserId'];
	}
   
 ?>
