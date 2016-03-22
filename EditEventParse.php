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

$eventId = $_GET["eventId"];//this is the id of the event that we are getting the information for.
$information = "";//this is the string that we will be feeding all the data into. its also what we will echo from this file back to the js function.


$query = "SELECT id, UserID, UserFirstName, UserLastName, EventName, BeginDateTime, EndDateTime, RepeatType, RepeatEndDate FROM events
						 WHERE id = $eventId" OR DIE(mysqli_error());
$result = mysqli_query($con,$query);

$splitVar = " ^?~-~?) ";

while($row = mysqli_fetch_array($result)){
	$dateTime = new DateTime($row['BeginDateTime']);// this is the date and the time that the event begins
	$endTime = new DateTime($row['EndDateTime']); //this is the date and the time that the event ends

	$information = $row['EventName'];
	$information .= $splitVar;
	$information .= $dateTime->format('m');
	$information .= $splitVar;
	$information .= $dateTime->format('d');
	$information .= $splitVar;
	$information .= $dateTime->format('h');
	$information .= $splitVar;
	$information .= $dateTime->format('i');
	$information .= $splitVar;
	$information .= $dateTime->format('A');
	$information .= $splitVar;
	$information .= $endTime->format('m');
	$information .= $splitVar;
	$information .= $endTime->format('d');
	$information .= $splitVar;
	$information .= $endTime->format('h');
	$information .= $splitVar;
	$information .= $endTime->format('i');
	$information .= $splitVar;
	$information .= $endTime->format('A');
	$information .= $splitVar;
	$information .= $row['RepeatType'];
	$information .= $splitVar;
	$information .= $row['RepeatEndDate'];
}
echo $information;
?>