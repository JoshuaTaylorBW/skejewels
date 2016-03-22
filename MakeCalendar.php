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


$Month = $_GET["Month"];
$Year = $_GET["Year"];

$ThisMonth = new dateTime(date("Y/".$Month."/01"));


$TheFirstDayOfWeek = intval($ThisMonth->format('w'));// what the first day of the month is of the week.
if($TheFirstDayOfWeek === 0){
	$Day = 7;
}else{
	$Day = $TheFirstDayOfWeek;
}
$WeekOne = 0;//if we've done week one already this turns into a 1
$LastDay = cal_days_in_month(CAL_GREGORIAN, $Month, $Year); // 31
$FirstSaturday = 0;
$LastSaturday = 0; //used for for loops to know where to start.
$DayInWeek = 1;//user for for loops to know when to end row of cells.
$CurrentDay = 0; //Which day we are on to add events to.
$Days = array();// array holding all days
$DateTimes = array();
$EventAmount = 0;//how many events are there?
$Blanks = 0;//how many blank spaces at start of first week.

$WeeklyRepeats = array();

//if user hasn't signed in. kick to the sign in page



//Makes days array
for ($i=0; $i <= $LastDay; $i++) {
	$Days[$i]="";
	$DateTimes[$i]="";
}
function debug_to_console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}
function MonthParse($Month)
{
	switch ($Month) {
		case 'Jan':
			return 1;
			break;
		case 'Feb':
			return 2;
			break;
		case 'Mar':
			return 3;
			break;
		case 'Apr':
			return 4;
			break;
		case 'May':
			return 5;
			break;
			case 'Jun':
			return 6;
			break;
			case 'Jul':
			return 7;
			break;
			case 'Aug':
			return 8;
			break;
			case 'Sep':
			return 9;
			break;
			case 'Oct':
			return 10;
			break;
			case 'Nov':
			return 11;
			break;
			case 'Dec':
			return 12;
			break;

		default:
			# code...
			break;
	}
}

function MakeNewRow($Start, $LastDay)
{
	if($Start <= $LastDay){
	echo "</tr>";
	echo "<tr align='center'>";
	for ($i=$Start; $i < $Start + 7; $i++) {
		if($i <= $LastDay){
			echo "	<td id='Day'>" . $i . "</td>";
		}else{
			echo "	<td id='Day'></td>";
		}
	}
	echo "</tr>";
	}
}


echo '<table>';

			echo "<tr align='center'>";
			if($Day === 7){ // if week starts on sunday
				echo "	<td id='Day'>1</td>";//Sunday
				echo "	<td id='Day'>2</td>";//Monday
				echo "	<td id='Day'>3</td>";//Tuesday
				echo "	<td id='Day'>4</td>";//Wednesday
				echo "	<td id='Day'>5</td>";//Thursday
				echo "	<td id='Day'>6</td>";//Friday
				echo "	<td id='Day'>7</td>"; //Saturday
				$FirstSaturday = 7;
			}elseif ($Day == 1) {
				echo "	<td id='Day'></td>";//Sunday
				echo "	<td id='Day'>1</td>";//Monday
				echo "	<td id='Day'>2</td>";//Tuesday
				echo "	<td id='Day'>3</td>";//Wednesday
				echo "	<td id='Day'>4</td>";//Thursday
				echo "	<td id='Day'>5</td>";//Friday
				echo "	<td id='Day'>6</td>"; //Saturday
				$FirstSaturday = 6;
			}elseif ($Day == 2) {
				echo "	<td id='Day'></td>";//Sunday
				echo "	<td id='Day'></td>";//Monday
				echo "	<td id='Day'>1</td>";//Tuesday
				echo "	<td id='Day'>2</td>";//Wednesday
				echo "	<td id='Day'>3</td>";//Thursday
				echo "	<td id='Day'>4</td>";//Friday
				echo "	<td id='Day'>5</td>"; //Saturday
				$FirstSaturday = 5;
			}elseif ($Day == 3) {
				echo "	<td id='Day'></td>";//Sunday
				echo "	<td id='Day'></td>";//Monday
				echo "	<td id='Day'></td>";//Tuesday
				echo "	<td id='Day'>1</td>";//Wednesday
				echo "	<td id='Day'>2</td>";//Thursday
				echo "	<td id='Day'>3</td>";//Friday
				echo "	<td id='Day'>4</td>"; //Saturday
				$FirstSaturday = 4;
			}elseif ($Day == 4) {
				echo "	<td id='Day'></td>";//Sunday
				echo "	<td id='Day'></td>";//Monday
				echo "	<td id='Day'></td>";//Tuesday
				echo "	<td id='Day'></td>";//Wednesday
				echo "	<td id='Day'>1</td>";//Thursday
				echo "	<td id='Day'>2</td>";//Friday
				echo "	<td id='Day'>3</td>"; //Saturday
				$FirstSaturday = 3;
			}elseif ($Day == 5) {
				echo "	<td id='Day'></td>";//Sunday
				echo "	<td id='Day'></td>";//Monday
				echo "	<td id='Day'></td>";//Tuesday
				echo "	<td id='Day'></td>";//Wednesday
				echo "	<td id='Day'></td>";//Thursday
				echo "	<td id='Day'>1</td>";//Friday
				echo "	<td id='Day'>2</td>"; //Saturday
				$FirstSaturday = 2;
			}elseif ($Day == 6) {
				echo "	<td id='Day'></td>";//Sunday
				echo "	<td id='Day'></td>";//Monday
				echo "	<td id='Day'></td>";//Tuesday
				echo "	<td id='Day'></td>";//Wednesday
				echo "	<td id='Day'></td>";//Thursday
				echo "	<td id='Day'></td>";//Friday
				echo "	<td id='Day'>1</td>"; //Saturday
				$FirstSaturday = 1;
			}

			$LastSaturday = $FirstSaturday;

			echo "</tr>";


	//Adding Events

			//filling initial empty spots
			if($Day != 7){
				echo "<tr align='center'>";
				for ($i=0; $i < $Day; $i++) {
					echo "<td id='Event' align='center'></td>";
					$Blanks++;
				}
			}
				$CurrentDay = 1;
			//Finishing First Week Events.

			//The id of the current user
			$currUserId=intval($_SESSION["UserId"]);

			//this fetches all the user's events in the current month. (ONLY GETS THE EVENTS THAT DON'T REPEAT)

			//this fetches all the repeating events
			$repeatQuery = "SELECT id, UserID, UserFirstName, UserLastName, EventName, BeginDateTime, EndDateTime, RepeatType, RepeatEndDate FROM events
						 WHERE (UserID='$currUserId' AND RepeatType != 'Once') OR (EXTRACT(MONTH FROM BeginDateTime) = '$Month' AND UserID='$currUserId' AND RepeatType = 'Once')
						   ORDER BY BeginDateTime"
			OR DIE(mysqli_error());


			$prevWeekly = 0;

			$repeatResult = mysqli_query($con, $repeatQuery);



			while ($row = mysqli_fetch_array($repeatResult)) {
				$dateTime = new DateTime($row['BeginDateTime']);// this is the date and the time that the event begins
				$endTime = new DateTime($row['EndDateTime']); //this is the date and the time that the event ends
				$endRepeatTime = new DateTime($row['RepeatEndDate']);//this is the date and time that the event stops repeating
				$repeatType = $row['RepeatType'];//finds the content in the database inside of the "RepeatType" column
				$repeatSplit = explode(' ', $repeatType);//splits the repeat type into the kind of repeat ([0]) and when the repeat is ([1])
				$Started = 0;
				if(intval($dateTime->format('Y')) == $Year){
					if($repeatType == 'Once'){
							if(intval($dateTime->format('i')) == 0){
							$Days[intval($dateTime->format('d'))] .= "<input id='OpenEditorButtons' type='submit' name='tags' onclick='edit(" . $row['id'] . ") ' value='" . intval($dateTime->format('h')) . $dateTime->format('A') . ' ' . $row['EventName'] . "'/><br>";//this adds the text in the calendar. the stuff at the beginning allows us to call a js function from NewMain that allows us to edit the event.
							}else{
								$Days[intval($dateTime->format('d'))] .= "<input id='OpenEditorButtons' type='submit' name='tags' onclick='edit(" . $row['id'] . ") ' value='" . intval($dateTime->format('h')) . ':' . $dateTime->format('i') . $dateTime->format('A') . ' ' . $row['EventName'] . "'/><br>";//this adds the text in the calendar. the stuff at the beginning allows us to call a js function from NewMain that allows us to edit the event.
							}
							$DateTimes[intval($dateTime->format('d'))] .= $row['EventName'] . ': ' . $dateTime->format('h').':'. $dateTime->format('i') .' '.$dateTime->format('A') . ' - ' . $endTime->format('h').':'. $endTime->format('i') .' '.$endTime->format('A') . "<br>";
							$EventAmount++;
					}
					if ($repeatSplit[0] == 'Weekly') { // if the event is repeated weekly
						for ($i=0; $i < 6; $i++) { //we go through six times because there is never a month in a year with more than six rows of days
							if($Started == 0){//after we make the first day this goes to a one
								if($Month >= MonthParse($dateTime->format('M'))){//if this calendar month is more than the starting month
										if($Month <= MonthParse($endRepeatTime->format('M'))){//if this calendar month is before than the ending month
										$firstDay = $repeatSplit[1] - ($TheFirstDayOfWeek) + 1; //first day is this.
										//if this month is the first month, we skip seven days until we're at the correct day to start
										if($Month == MonthParse($dateTime->format('M'))){//if we are working in the month that the date begins
											//then we check that the event starts on the first day. if not, we add a week until its to the correct date
											while ($firstDay < intval($dateTime->format('d'))) {
												$firstDay += 7;
											}
										}
										$prevWeekly = $firstDay;
										//if we, for example, start on wednesday and the month starts on thursday we skip the first week
										if($firstDay < 0){
											$firstDay += 7;
										}

								// if we start at the top of the hour we dont add the extra detail of the time


								if(intval($dateTime->format('i')) == 0){

											$Days[$firstDay] .= "<input id='OpenEditorButtons' type='submit' name='tags' onclick='edit(" . $row['id'] . ")' value='" . intval($dateTime->format('h')) . $dateTime->format('A') . ' ' . $row['EventName'] . "'/><br>";//this adds the text in the calendar. the stuff at the beginning allows us to call a js function from NewMain that allows us to edit the event.
										}else{//or else we do
											$Days[$firstDay] .= "<input id='OpenEditorButtons' type='submit' name='tags' onclick='edit(" . $row['id'] . ")' value='" . intval($dateTime->format('h')) . ':' . $dateTime->format('i') . $dateTime->format('A') . ' ' . $row['EventName'] . "'/><br>";//this adds the text in the calendar. the stuff at the beginning allows us to call a js function from NewMain that allows us to edit the event.
										}
										$DateTimes[$firstDay] .= $row['EventName'] . ': ' . $dateTime->format('h').':'. $dateTime->format('i') .' '.$dateTime->format('A') . ' - ' . $endTime->format('h').':'. $endTime->format('i') .' '.$endTime->format('A') . "<br>";
										$EventAmount++;
										$Started++;//makes it so we move to the next if when the loop goes around again.
									}

								}
							}else{// if this is not the first week of the month
								if(intval($prevWeekly + 7) <= $LastDay){//if this day is before than the last day of the month

									if($Month < MonthParse($endRepeatTime->format('M'))){//if this month is before the last month
										if(intval($prevWeekly + 7) == $firstDay){
											$CurrDay = $prevWeekly + 7;//makes it so we move on to the next week when we place the event
											$prevWeekly = $CurrDay;//prevWeekly is our global variable. we make it equal to the current day
										}else{
											$CurrDay = $prevWeekly + 7;//makes it so we move on to the next week when we place the event
											$prevWeekly = $CurrDay;//prevWeekly is our global variable. we make it equal to the current day
											if(intval($dateTime->format('i')) == 0){
												$Days[$prevWeekly] .= "<input id='OpenEditorButtons' type='submit' name='tags' onclick='edit(" . $row['id'] . ")' value='" . intval($dateTime->format('h')) . $dateTime->format('A') . ' ' . $row['EventName'] . "'/><br>";//this adds the text in the calendar. the stuff at the beginning allows us to call a js function from NewMain that allows us to edit the event.
											}else{
												$Days[$prevWeekly]  .= "<input id='OpenEditorButtons' type='submit' name='tags' onclick='edit(" . $row['id'] . ")' value='" . intval($dateTime->format('h')) . ':' . $dateTime->format('i') . $dateTime->format('A') . ' ' . $row['EventName'] . "'/><br>";//this adds the text in the calendar. the stuff at the beginning allows us to call a js function from NewMain that allows us to edit the event.
											}
											$DateTimes[$prevWeekly]  .= $row['EventName'] . ': ' . $dateTime->format('h').':'. $dateTime->format('i') .' '.$dateTime->format('A') . ' - ' . $endTime->format('h').':'. $endTime->format('i') .' '.$endTime->format('A') . "<br>";
											$EventAmount++;
									}
										//if we are working in the event that the event stops repeating
									}elseif($Month == MonthParse($endRepeatTime->format('M')) && intval($prevWeekly + 7) < $LastDay) {

										if(intval($prevWeekly + 7) == $firstDay){
											$CurrDay = $prevWeekly + 7;//makes it so we move on to the next week when we place the event
											$prevWeekly = $CurrDay;//prevWeekly is our global variable. we make it equal to the current day
										}else{
											$CurrDay = $prevWeekly + 7;//makes it so we move on to the next week when we place the event
											$prevWeekly = $CurrDay;

											//checks if this version of the event is being placed correctly (as in before the endDate)
										if(intval($prevWeekly <= $endRepeatTime->format('d'))){
											if(intval($dateTime->format('i')) == 0){
												$Days[$prevWeekly] .= "<input id='OpenEditorButtons' type='submit' name='tags' onclick='edit(" . $row['id'] . ") disabled' value='" .intval($dateTime->format('h')) . $dateTime->format('A') . ' ' . $row['EventName'] . "'/><br>";//this adds the text in the calendar. the stuff at the beginning allows us to call a js function from NewMain that allows us to edit the event.
											}else{
												$Days[$prevWeekly]  .= "<input id='OpenEditorButtons' type='submit' name='tags' onclick='edit(" . $row['id'] . ") disabled' value='" .intval($dateTime->format('h')) . ':' . $dateTime->format('i') . $dateTime->format('A') . ' ' . $row['EventName'] . "'/><br>";//this adds the text in the calendar. the stuff at the beginning allows us to call a js function from NewMain that allows us to edit the event.
											}
										}
										$DateTimes[$prevWeekly]  .= $row['EventName'] . ': ' . $dateTime->format('h').':'. $dateTime->format('i') .' '.$dateTime->format('A') . ' - ' . $endTime->format('h').':'. $endTime->format('i') .' '.$endTime->format('A') . "<br>";
										$EventAmount++;
									}
										}
									}
								}
							}
					}elseif($repeatSplit[0] == 'Monthly'){//if the event is repeated monthly
						if($Month >= MonthParse($dateTime->format('M'))){//if this calendar month is more than the starting month

							if($Month <= MonthParse($endRepeatTime->format('M'))){//if this calendar month is before than the ending month
								if(intval($dateTime->format('i')) == 0){
									$Days[intval($repeatSplit[1])] .= "<input id='OpenEditorButtons' type='submit' name='tags' onclick='edit(" . $row['id'] . ")'  value='" . intval($dateTime->format('h')) . $dateTime->format('A') . ' ' . $row['EventName'] . "'/><br>";//this adds the text in the calendar. the stuff at the beginning allows us to call a js function from NewMain that allows us to edit the event.
								}else{
									$Days[intval($repeatSplit[1])]  .= "<input id='OpenEditorButtons' type='submit' name='tags' onclick='edit(" . $row['id'] . ")' value='" . intval($dateTime->format('h')) . ':' . $dateTime->format('i') . $dateTime->format('A') . ' ' . $row['EventName'] . "'/><br>";//this adds the text in the calendar. the stuff at the beginning allows us to call a js function from NewMain that allows us to edit the event.
								}
									$DateTimes[intval($repeatSplit[1])]  .= $row['EventName'] . ': ' . $dateTime->format('h').':'. $dateTime->format('i') .' '.$dateTime->format('A') . ' - ' . $endTime->format('h').':'. $endTime->format('i') .' '.$endTime->format('A') . "<br>";

							}
						}
					}
				}
			}


				while ($CurrentDay <= $LastDay) {
				if($WeekOne == 0){
					//if($Day != 7){
					for($i=$CurrentDay; $i <= $FirstSaturday; $i++){
						if($Blanks + $CurrentDay <= 4){
							echo "<td id='Event' align='center'><a class='rightTooltip' onclick='' href='#'>". $Days[$i] ."<span class='classic'>" . $DateTimes[$i] . "</span></a></td>";
							$CurrentDay++;
							$DayInWeek++;
							}else{
								echo "
									<td id='Event' align='center'><a class='leftTooltip' href='#'>". $Days[$i] ."<span class='classic'>" . $DateTimes[$i] . "</span></a></td>";
							$CurrentDay++;
							$DayInWeek++;
							}
						}

					echo "</tr>";

					echo "<tr align='center'>";
					$LastSaturday = $CurrentDay - 1;
					$WeekOne++;
					for ($i=$LastSaturday + 1; $i <= $LastSaturday + 7 ; $i++) {
						echo "	<td id='Day'>" . $i . "</td>";
					}
					echo "</tr>";

				}else{
					$DayInWeek = 0;
						for($i=$CurrentDay; $i<$CurrentDay+7; $i++){
							if($i<=$LastDay){
								if($DayInWeek <= 3){
							echo "
									<td id='Event' align='center'><a class='rightTooltip' href='#'>". $Days[$i] ."<span class='classic'>". $DateTimes[$i] ."</span></a></td>";

							}else{
								echo "
									<td id='Event' align='center'><a class='leftTooltip' href='#'>". $Days[$i] ."<span class='classic'>" . $DateTimes[$i] . "</span></a></td>";

							}
							}else {
								echo "<td id='Event' align='center'></td>";;
							}


						$LastSaturday = $i;
						$DayInWeek++;
						}
						echo "</tr>";

						$CurrentDay += 7;
						MakeNewRow($CurrentDay, $LastDay);

				}
			}




			//Finding and sorting events.

			echo "<tr align='center'>";



	echo "</table>";
	echo $con->error;

 ?>
