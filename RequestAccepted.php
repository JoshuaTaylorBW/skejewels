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

$id = $_GET["id"];//the id of the user who's request we accepted.
$currRequests = "";
$newRequests="";
$currFriends="";
$newFriends="";
$acceptedRequestUsersName="";//the first and last name of the person whos friend request has been accepted.

//change current users friends list//

while ($row = mysqli_fetch_array($result)) { 

	//get the line with all the id's of the people who have requested friendship
	$currRequests = $row["RequestsFrom"];

	//split the line into individual user ids. all the people who have requested friendship
	$indivs = explode(",", $currRequests);
	
	//line that contains all current friends before acceptance of current request
	$newFriends = $row["Friends"];
	$acceptedRequestUsersName = $row['id'] . ',' . $row['UserFirstName'] . ' ' . $row['UserLastName'];
	//go through all of the people who have requested friendship
	for ($i=0; $i < count($indivs); $i++) { 
		//if $i is the request we have accepted
		if(intval($indivs[$i]) == intval($id)){	
			//if the user has no friends
			if($newFriends === ""){
				$newFriends .= $indivs[$i];//this request is their first friend
			//if the user already has at least one friend
			}else{
				$newFriends = $newFriends . $indivs[$i] . ","; //add this friend to the list with a comma
			}
		//if this is not the request we have accepted
		}else{
			//if we haven't added any of the old requests back into the database. 
			if($newRequests === ""){
				$newRequests = $indivs[$i] + ",";//this is the first request from somebody else in the database
			}else{
				$newRequests = $newRequests . $indivs[$i] . ",";//this is after the first request.
			}		
		}
	}
}

//get all the columns from the users database table where the id equals the id of the person who's request we accepted.
$query2 = ("SELECT * FROM users WHERE id=$id")	OR DIE(mysqli_error());
$result2 = mysqli_query($con,$query2);


$currRequests2 = "";
$newRequests2="";
$currFriends2="";
$newFriends2="";

while ($row2 = mysqli_fetch_array($result2)) { //change person whos friend request has been accepted friends list
	$currRequests2 = $row2["RequestsFrom"];
	$indivs = explode(",", $currRequests);
	$newFriends2 = $row2["Friends"];

	

	if($newFriends2 === ""){
		$newFriends2 .= $currUserId . ",";
	}else{
		$newFriends2 = $newFriends2 . $currUserId . ",";
	}
}


$sql = "UPDATE users SET RequestsFrom='$newRequests', Friends='$newFriends' WHERE id=$currUserId";
$sql2 = "UPDATE users SET Friends='$newFriends2' WHERE id=$id";

$splitVar = '?^--^?';
$addVar = $acceptedRequestUsersName . ', has accepted your friend request.,0'  . $splitVar;
$updateUsers = "UPDATE users SET Notifications = CONCAT('$addVar', Notifications),
	NewNotifications = NewNotifications + 1 WHERE id='$id'";
if ($con->query($sql) === TRUE) {
	if ($con->query($sql2) === TRUE) {
		if ($con->query($updateUsers) === TRUE) {
		}
	}
}else{
    echo "Error updating record: " . $con->error;
}

 ?>
