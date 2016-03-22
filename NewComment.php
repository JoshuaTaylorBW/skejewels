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

//camel case. sorry bout it
$commentEventId = $_GET['statusId']; //the id of the status that we are adding the comment to.
$commentVal = $_GET['comment'];
$commentUser = $_SESSION['FirstNames'] . ' ' . $_SESSION['LastNames'];
$userNickname = $_SESSION['Nickname'];
$userId = $_SESSION['UserId'];
$addEvent = $_SESSION['UserId'] . ",";


if(!empty($commentVal)){

	$query = "SELECT EventName FROM events WHERE  id='$commentEventId'";
	$result = mysqli_query($con, $query);
	while ($row = mysqli_fetch_array($result)) {
		$eventName = $row['EventName'];
	}

	$commentInsert = str_replace("'", "", $commentVal);
	$sql = "INSERT INTO Comments (CommentStatusId, Comment, CommenterName, CommenterNickname, CommenterId) VALUES
				('$commentEventId', '$commentInsert', '$commentUser', '$userNickname', '$userId')";
	if ($con->query($sql) === TRUE) {
		   	echo "Worked....";
		}else{
			echo "MEssed up" . $con->error;
		}

	$sql2 = "UPDATE events SET CommentAmount=CommentAmount+1 WHERE id = '$commentEventId'";
	if ($con->query($sql2) === TRUE) {
	}else{
		echo "MEssed up" . $con->error;
	}
	$splitVar = '?^--^?';
	$realComment = str_replace(",", "", $commentVal);
	$addVar = $addEvent . $commentUser . ",  said \'" . $realComment . "\' on  your event ," . $eventName . "," . $commentEventId . $splitVar; 

	$updateUsers = "UPDATE users SET Notifications = CONCAT('$addVar', Notifications),
		NewNotifications = NewNotifications + 1 WHERE id='$userId'";

	if ($con->query($updateUsers) === TRUE) {
		   	echo "Worked....";
		}else{
			echo "MEssed up" . $con->error;
		}
}

 ?>
