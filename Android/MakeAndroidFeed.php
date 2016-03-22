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

	$friendly = "1,170,174,173,166,166,166,166,166,166,";
	$array=array_map('intval', explode(',', $friendly));
	$array = implode("','",$array);
	$today = new DateTime('NOW');// this is the date and the time that the event begins
	$length = $_GET['length'];

	// $query = "SELECT * FROM events WHERE Visibility='Public' AND UserID IN 
	// ('".$array."') AND BeginDateTime > DATE_SUB(NOW(), INTERVAL 15 MINUTE) 
	// ORDER BY BeginDateTime LIMIT $length"
	// 	OR DIE(mysqli_error());
	$query = "SELECT * FROM events WHERE Visibility='Public' AND UserID = 1 AND BeginDateTime > DATE_SUB(NOW(), INTERVAL 15 MINUTE) 
	 ORDER BY BeginDateTime LIMIT $length"
	 	OR DIE(mysqli_error());
	$result = mysqli_query($con, $query);
	$which = 0;//which box are we spawning

	$entire = "";
	$entireEntire = "doubledtumbleswillfumblemybumblebee";

	//doubledtumbleswillfumblemybumblebee

	while($row = mysqli_fetch_array($result)){
		$dateTime = new DateTime($row['BeginDateTime']);// this is the date and the time that the event begins
		$endTime = new DateTime($row['EndDateTime']); //this is the date and the time that the event ends
		$alreadyLiked = false;//checks if the user has already liked the status so we spawn as unlike.
		//first line creates div
		//second line creates link
		//third line attaches link to name of user
		//fourth line writes where the user is going to 
		//fifth line writes month and day that the user is going to event
		//sixth line writes hour and minute that the user is going to that event. 
		//seventh line ends div

		//UserID UserFirstName UserNickname EventName LikedIds CommentAmount MostRecentLike LikeAmount id
		$usersName = $row['UserFirstName'] . " " . $row['UserLastName'];
		$entire = "pampurppampurpampurp" . $row['UserID'] . "pampurppampurpampurp" . $row['EventName'] . "pampurppampurpampurp" . $usersName . "pampurppampurpampurp" . $row['CommentAmount'] . "pampurppampurpampurp" . $row['LikeAmount'] . "pampurppampurpampurp" . $row['id'] . "pampurppampurpampurp" . $dateTime . "pampurppampurpampurp" . $endTime;

		$entireEntire .= $entire . "doubledtumbleswillfumblemybumblebee";
		  $which++;
	}
	print(json_encode($entireEntire));

?>