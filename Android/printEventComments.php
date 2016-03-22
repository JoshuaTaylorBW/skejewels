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

$EventId = $_GET['EventId'];

$query = "SELECT * FROM Comments WHERE CommentStatusId = '$EventId' ORDER BY CommentId ASC";
$result = mysqli_query($con, $query);

$commentsOfEvent = "";
$amount = 0;
while ($row = mysqli_fetch_array($result)){
	//pampurppampurpampurp
	if($commentsOfEvent == ""){
		$commentsOfEvent =  $row['Comment'] . "pampurppampurpampurp" . $row['CommenterName'] . "pampurppampurpampurp" . $row['CommenterId'] . "pampurppampurpampurp"; 
	}else{
		$commentsOfEvent .=  $row['Comment'] . "pampurppampurpampurp" . $row['CommenterName'] . "pampurppampurpampurp" . $row['CommenterId'] . "pampurppampurpampurp";
	}

	$amount++;
	}
	$finalCommentsOfEvent = "pampurppampurpampurp" . $amount . "pampurppampurpampurp" . $commentsOfEvent;
	print(json_encode($finalCommentsOfEvent));

 ?>