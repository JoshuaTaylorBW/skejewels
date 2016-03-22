<?php
	$servername = "127.0.0.1";
	$username = "joshuaboywonder";
	$password = "ninjaninja81";
	$dbname = "skejewel";
	session_start();

	$con=new mysqli($servername,$username,$password, $dbname);
	if($con->connect_error){
		die("connection failed " . $con->connect_error);
	}
	mysqli_select_db($con, "skejewel");

	$limit = $_GET['limit'];
	$currUserId = $_SESSION["UserId"];


	$query = "SELECT * FROM users WHERE id='$currUserId'"
		OR DIE(mysqli_error());

	$result = mysqli_query($con, $query);
	$splitVar = '?^--^?';
	$notesMade = 0;
	while ($row = mysqli_fetch_array($result)) {
		$allNotifications = $row['Notifications'];
		if($row['NewNotifications'] > 10){
			$indivsNotifs = explode('?^--^?', $allNotifications, $row['NewNotifications'] + 1);
		}else{
			$indivsNotifs = explode('?^--^?', $allNotifications, $limit);
		}
		for ($i=1; $i < count($indivsNotifs); $i++) {
			$indivInfo = explode(',', $indivsNotifs[$i - 1]);
			if($indivInfo[3] === '0'){
				$realEventname="";
			}else{
				$realEventname = str_replace("'", "", $indivInfo[3]);
			}
			echo "<div id='NotificationsContainer' style='padding-bottom:20px;'>
				<a id='nameLink' align='center' href='CheckFriends.php?id=" . $indivInfo[0] ."'>"
				. $indivInfo[1] . "</a>";
			if($indivInfo[3] === '0'){
				echo "<span id='noteType' align='center'> " . $indivInfo[2] . "</span></br>";
			}else{
				echo "<span id='noteType' align='center'> " . $indivInfo[2] . ":</span>";
			}
			echo "<span id='eventName' style='padding-top:10px;'> " . $realEventname . "</span>";
			echo "</div>";
			$notesMade++;
		}
		if($notesMade % 10 === 0 && $notesMade > 0 ){
			echo "<div id='NotificationFooter'><input id='MoreNotificationsButton' type='submit'onclick='longerNotifications();' value='Load More'></input></br></div>";
		}else{
			echo "<div id='NotificationFooter'></div>";

		}
	}
	$insert = "UPDATE users SET NewNotifications = 0 WHERE id='$currUserId'";
			mysqli_query($con, $insert);
 ?>
