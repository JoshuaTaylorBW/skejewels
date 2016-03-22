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

$id = $_GET['id'];
$n = $_GET['n'];
$sM = $_GET['sM'];
$sD = $_GET['sD'];
$sH = $_GET['sH'];
$sMi = $_GET['sMi'];

$eM = $_GET['eM'];
$eD = $_GET['eD'];
$eH = $_GET['eH'];
$eMi = $_GET['eMi'];
$rT = $_GET['rT'];
$v = $_GET['v'];

$name = $_SESSION['UserId'];
$FirstName = $_SESSION['FirstNames'];
$LastName = $_SESSION['LastNames'];
$nameInsert = str_replace("'", "", $n);


$date = '2016-$sM-$sD $sH:$sMi:00'; 
$weeklyRepeatDay = date("w", $date);


if(!empty($n)){
	$sql = "UPDATE events 
	SET EventName='$nameInsert', BeginDateTime='2016-$sM-$sD $sH:$sMi:00',
	 EndDateTime='2016-$eM-$eD $eH:$eMi:00', Visibility='$v' WHERE id = $id";
	if ($con->query($sql) === TRUE) {
	   	
	}else{
		echo "MEssed up" . $con->error;
	}
}
?>
