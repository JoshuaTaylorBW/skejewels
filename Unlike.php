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

$currUserId = $_SESSION["UserId"];
$eventId = $_GET['eventId']; // the id of the event the user liked
$query = ("SELECT * FROM events WHERE id=$eventId")	OR DIE(mysqli_error());
$result = mysqli_query($con,$query);

$currLikes = "";
$newLikes="";

$RecentPerson = ""; //the id of the last person to like the status

while ($row = mysqli_fetch_array($result)){
	$currLikes = $row['LikedIds'];
	$indivs = explode(",", $currLikes);

	for ($i=0; $i < count($indivs); $i++) { 
		if(intval($indivs[$i]) == intval($currUserId)){	
		}else{
			if($newLikes === ""){
				$newLikes = $indivs[$i] + ",";
			}else{
				$newLikes = $newLikes . $indivs[$i] . ",";
			}
		}
	}
	$recentIndivs = explode(" ", $row['MostRecentLike']);
	$RecentPerson = $recentIndivs[0];
}

if($RecentPerson == $_SESSION['UserId']){
	if($newLikes == "0"){
		$sql = "UPDATE events SET LikedIds=NULL, LikeAmount=0, MostRecentLike = NULL WHERE id='$eventId'";
	}else{
		$sql = "UPDATE events SET LikedIds='$newLikes', LikeAmount = LikeAmount-1, MostRecentLike = NULL  WHERE id='$eventId'";	
	}
}else{
		$sql = "UPDATE events SET LikedIds='$newLikes', LikeAmount = LikeAmount-1 WHERE id='$eventId'";		
}
if ($con->query($sql) === TRUE) {
	echo $newLikes;
} else {
    echo "Error updating record: " . $con->error;
}

 ?>