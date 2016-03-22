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



$ThisMonth = $_GET['Month'];
$ThisDay = $_GET['Day'];
$ThisYear = $_GET['Year'];
$FirstDayOfMonth = new dateTime(date("Y-" . intval($ThisMonth) . "-1 H:i:s"));
$TheFirstDayOfWeek = intval($FirstDayOfMonth->format('w')) + 1;// what the first day of the month is of the week. 

	$repeatQuery = "SELECT id, UserID, UserFirstName, UserLastName, EventName, BeginDateTime, EndDateTime, RepeatType, RepeatEndDate FROM events
						 WHERE (UserID=1 AND RepeatType != 'Once' AND EXTRACT(MONTH FROM RepeatEndDate) >= '$ThisMonth' AND EXTRACT(MONTH FROM BeginDateTime) <= '$ThisMonth'
						 	AND EXTRACT(YEAR FROM RepeatEndDate) >= '$ThisYear' AND EXTRACT(YEAR FROM BeginDateTime) <= '$ThisYear') 
						 OR (EXTRACT(MONTH FROM BeginDateTime) = '$ThisMonth' AND UserID=1 AND RepeatType = 'Once'  AND EXTRACT(DAY FROM BeginDateTime) = '$ThisDay' AND EXTRACT(YEAR FROM BeginDateTime) = '$ThisYear')
						   ORDER BY BeginDateTime"
			OR DIE(mysqli_error());

	$repeatResult = mysqli_query($con, $repeatQuery);
			
			
	$days="";
	$names="";
	$times="";

	

	function convertWeek($serverDay)
	{
		$realDay = 0;
		switch ($serverDay) {
			case 7:
				$realDay = 1;
				break;
			case 1:
				$realDay = 2;
				break;
			case 2:
				$realDay = 3;
				break;
			case 3:
				$realDay = 4;
				break;
			case 4:
				$realDay = 5;
				break;
			case 5:
				$realDay = 6;
				break;
			case 6:
				$realDay = 7;
				break;
			default:
				break;
		}
		return $realDay;
	}

	while ($row = mysqli_fetch_array($repeatResult)) {
		$dateTime = new DateTime($row['BeginDateTime']);// this is the date and the time that the event begins
		$endDateTime = new DateTime($row['EndDateTime']);// this is the date and the time that the event begins
		$printId = 	$row['id'];

		//REPEAT VARIABLES
		$endRepeatTime = new DateTime($row['RepeatEndDate']);//this is the date and time that the event stops repeating
		$repeatType = $row['RepeatType'];//finds the content in the database inside of the "RepeatType" column
		$repeatSplit = explode(' ', $repeatType);//splits the repeat type into the kind of repeat ([0]) and when the repeat is ([1])
		if($repeatType == 'Once'){
			if($names == ""){
				$days = intval($dateTime->format('d')) . ",";
				$names = $row['EventName'] . ",";
				$times =  "" . $dateTime->format('H') . ":" . $dateTime->format('i') . "-" . $endDateTime->format('H') . ":" . $endDateTime->format('i') . ",";
			}else{
				$days .= "" . intval($dateTime->format('d')) . ",";	
				$names .= $row['EventName'] . ",";
				$times .= "" .  $dateTime->format('H') . ":" . $dateTime->format('i') . "-" . $endDateTime->format('H') . ":" . $endDateTime->format('i') . ",";	
			}
		}
			if($repeatSplit[0] == 'Monthly') {
				if($ThisDay == $repeatSplit[1])
					if($names == ""){
						$days = "" . intval($dateTime->format('d')) . ",";
						$names = $row['EventName'] . ",";
						$times = "" .  $dateTime->format('H') . ":" . $dateTime->format('i') . "-" . $endDateTime->format('H') . ":" . $endDateTime->format('i') . ",";
					}else{
						$days .= "" . intval($dateTime->format('d')) . ",";	
						$names .= $row['EventName'] . ",";
						$times .= "" .  $dateTime->format('H') . ":" . $dateTime->format('i') . "-" . $endDateTime->format('H') . ":" . $endDateTime->format('i') . ",";	
					
				}	
			}
				if($repeatSplit[0] == 'Weekly') {
					$dayOfEvent = convertWeek(intval($repeatSplit[1]));
					$firstEventDay = 0;
					if($dayOfEvent >= $TheFirstDayOfWeek + 1){
						$firstEventDay = $dayOfEvent - $TheFirstDayOfWeek + 1;
					}else{
						$firstEventDay = (7 - $TheFirstDayOfWeek) + $dayOfEvent + 1;
					}
	
					$nextDay = $firstEventDay;
	
					while($nextDay < 31){
						$possible = true;
						if($dateTime->format("m") == $ThisMonth){//if this is the month the weekly event begins in
							if($nextDay < intval($dateTime->format('d'))){//if nextDay is before the event starts
								$possible = false;
							}
						}
	
						if(intval($endRepeatTime->format("m")) == $ThisMonth){//also, if the event stops repeating this month
							if($nextDay > intval($endRepeatTime->format('d'))){//if nextDay is after the event has stopped repeating
								$possible = false;
							}
						}
						if($possible){
							if($ThisDay == $nextDay){

							if($names == ""){
								$days = $nextDay . ",";
								$names = $row['EventName'] . ",";
								$times = "" .  $dateTime->format('H') . ":" . $dateTime->format('i') . "-" . $endDateTime->format('H') . ":" . $endDateTime->format('i') . ",";
							}else{
								$days .= $nextDay . ",";
								$names .= $row['EventName'] . ",";
								$times .= "" . $dateTime->format('H') . ":" . $dateTime->format('i') . "-" . $endDateTime->format('H') . ":" . $endDateTime->format('i') . ",";		
							}
						}
						}
						
						$nextDay = $nextDay + 7;
					}
		}
	}

	$allDays = explode(',', $days);
	$allNames = explode(',', $names);
	$allTimes = explode(',', $times);


	$daysEvents = "";
	$splitVar = '-?-';
	$eventsMade = 0;

	for ($i=0; $i < count($allDays); $i++) { 
		if(intval($allDays[$i]) == intval($ThisDay)){
			if($daysEvents == ""){
				$daysEvents = '-?- ' . $allNames[$i] . 'pampurppampurpampurp' . $printId . $splitVar . $allTimes[$i] . $splitVar;//$allNames[$i] . $splitVar . $allTimes[$i] . $splitVar
				$eventsMade = $eventsMade + 1;
			}else{
				$daysEvents .= $allNames[$i] . 'pampurppampurpampurp' .$printId . $splitVar . $allTimes[$i] . $splitVar;				
			}
		}
	}
	
	print(json_encode($daysEvents));
 ?>