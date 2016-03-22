<?php 
	//Connect to the database
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

	$friendly = "";
	$friendly .= $_SESSION['Friends'];
	$array=array_map('intval', explode(',', $friendly));
	$array = implode("','",$array);
	$today = new DateTime('NOW');// this is the date and the time that the event begins

	$query = "SELECT * FROM events WHERE Visibility='Public' AND UserID IN ('".$array."') ORDER BY id DESC LIMIT 10"
		OR DIE(mysqli_error());
	$result = mysqli_query($con, $query);

	while($row = mysqli_fetch_array($result)){
		$dateTime = new DateTime($row['BeginDateTime']);// this is the date and the time that the event begins
		$endTime = new DateTime($row['EndDateTime']); //this is the date and the time that the event ends
		//first line creates div
		//second line creates link
		//third line attaches link to name of user
		//fourth line writes where the user is going to 
		//fifth line writes month and day that the user is going to event
		//sixth line writes hour and minute that the user is going to that event. 
		//seventh line ends div
		 echo "<div id='FeedEvent'>
		 <a id='nameLink' href='CheckFriends.php?id=" . $row['UserID'] ."'>".
		  $row['UserFirstName'] . ' ' . $row['UserLastName'] ."</a>" .
		 "<span> Scheduled " . $row['EventName'] .
		  ' for ' . $dateTime->format('m-d') . 
		  ' at ' . $dateTime->format('h:i') . '</span><br>' .
		  '</div>';

	}


?>