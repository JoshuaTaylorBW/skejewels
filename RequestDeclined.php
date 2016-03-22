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
$query = ("SELECT * FROM users WHERE id=$currUserId")	OR DIE(mysqli_error());
$result = mysqli_query($con,$query);

$id = $_GET["id"];//the id of the user who's request we declined.
$currRequests = "";
$newRequests="";

while ($row = mysqli_fetch_array($result)) {
	$currRequests = $row["RequestsFrom"];
	$indivs = explode(",", $currRequests);

	for ($i=0; $i < count($indivs); $i++) { 
		if(intval($indivs[$i]) == intval($id)){	
		}else{
			if($newRequests === ""){
				$newRequests = $indivs[$i] + ",";
			}else{
				$newRequests = $newRequests . $indivs[$i] . ",";
			}		
		}
	}
}

$sql = "UPDATE users SET RequestsFrom='$newRequests' WHERE id=$currUserId";
echo "Got to here";
if ($con->query($sql) === TRUE) {
    header( 'Location: NotFriends.php?id='.$otherId .' ' . $otherName);

} else {
    echo "Error updating record: " . $con->error;
}

 ?>
