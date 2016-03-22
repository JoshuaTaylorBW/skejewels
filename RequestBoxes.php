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

	$currUserId = $_SESSION['UserId'];

	$query = "SELECT RequestsFrom FROM users WHERE id='$currUserId'";
	$result = mysqli_query($con, $query);
	while ($row = mysqli_fetch_array($result)) {
		$indivRequests = explode(',', $row['RequestsFrom']);
		for ($i=0; $i < count($indivRequests); $i++) {
			$query2 = "SELECT UserFirstName, UserLastName, Nickname FROM users
				WHERE id='$indivRequests[$i]'";
			$result2 = mysqli_query($con, $query2);

			while ($row2 = mysqli_fetch_array($result2)) {
			echo "<div id='RequestsContainer'>
				<a id='RequestNameLink' align='center' href='CheckFriends.php?id=" . $indivRequests[$i] . "'>"
				. $row2['UserFirstName'] . " " . $row2['UserLastName'] . "</a>";
			echo "<span id=userNickName>@" . $row2['Nickname'] . "</span></br>";
			echo "<span id='requestNoteType' align='center'> Wants to be your </br> friend</span></br>";
			echo "<input type='submit' id='acceptButton' value='Accept' onclick='Added(" . $indivRequests[$i] . ")'>";
			echo "<input type='submit' id='declineButton' value='Decline' onclick='
			Declined(" . $indivRequests[$i] . ")'>";
			echo"</div>";
		}
		}
	}

	$insert = "UPDATE users SET NewFriends = 0 WHERE id='$currUserId'";
			mysqli_query($con, $insert);
 ?>
