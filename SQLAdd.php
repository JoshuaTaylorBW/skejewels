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
$eRM = $_GET['eRM'];
$eRD = $_GET['eRD'];

$v = $_GET['v'];

$name = $_SESSION['UserId'];

$FirstName = $_SESSION['FirstNames'];
$LastName = $_SESSION['LastNames'];
$nickname = $_SESSION['Nickname'];
//Repeat Stuff...
$finalRepeat = "";//this is the final answer we put into the request
$repeatDay = 0;//this is the day of week or month we repeat the event
$repeatType = $rT;//this is either Once, Weekly, or Monthly
$endRepeat="0000-00-00";
$sql = "";
$nameInsert = str_replace("'", "", $n);
$secondName = str_replace("-", "", $nameInsert);
$finalName = str_replace("?^--^?", "Walrus", $secondName);


if(!empty($n)){

	if($repeatType == "Once"){
		$sql = "INSERT INTO events (UserID, UserFirstName, UserLastName, UserNickname,
		EventName, BeginDateTime, EndDateTime, RepeatType,  Visibility)
			VALUES ('$name', '$FirstName', '$LastName', '$nickname', '$finalName',
					 '2016-$sM-$sD $sH:$sMi:00','2016-$eM-$eD $eH:$eMi:00',
					 'Once', '$v')";
		if ($con->query($sql) === TRUE) {
		   	echo "Worked....";
		}else{
			echo "MEssed up" . $con->error;
		}
	}else if ($repeatType == "Weekly") {
		$repeatDay = date("N", strtotime("2016-$sM-$sD $sH:$sMi:00"));
		
		if($repeatDay == 0){
			$finalRepeat = "Weekly 07";
		}else{
			$finalRepeat = "Weekly " . $repeatDay;
		}
		$sql = "INSERT INTO events (UserID, UserFirstName, UserLastName,
			EventName, BeginDateTime, EndDateTime, RepeatType, RepeatEndDate, Visibility)
				VALUES ('$name', '$FirstName', '$LastName', '$finalName',
						 '2016-$sM-$sD $sH:$sMi:00','2016-$eM-$eD $eH:$eMi:00',
						 '$finalRepeat', '2016-$eRM-$eRD $eH:$eMi:00', '$v')";
		if ($con->query($sql) === TRUE) {
		   	echo "Worked....";
		}else{
			echo "MEssed up" . $con->error;
		}
	}else if($repeatType == "Monthly"){
			$finalRepeat = "Monthly " . $sD;
		$sql = "INSERT INTO events (UserID, UserFirstName, UserLastName,
			EventName, BeginDateTime, EndDateTime, RepeatType, RepeatEndDate, Visibility)
				VALUES ('$name', '$FirstName', '$LastName', '$finalName',
				 '2016-$sM-$sD $sH:$sMi:00','2016-$eM-$eD $eH:$eMi:00',
				 '$finalRepeat', '2016-$eRM-$eRD $eH:$eMi:00','$v')";
		if ($con->query($sql) === TRUE) {
		   	echo "Worked....";
		}else{
			echo "MEssed up" . $con->error;
		}
	}
}
?>
