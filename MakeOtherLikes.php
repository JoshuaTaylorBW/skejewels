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
	//GET VARIABLES
		$EventId = $_GET['EventId']; // the id of the event we're finding likes for. So that we can get the rows.
		$otherPeopleIndivs = array();//the individual ids of the people we're finding.

	//Make Div
		$queryOne = "SELECT id, LikedIds FROM events WHERE id='$EventId'";
		$result = mysqli_query($con, $queryOne);
		

	//Make individual boxes
		while ($row = mysqli_fetch_array($result)) {
			$otherPeopleIndivs = explode(",", $row['LikedIds']);
		}
		echo "<div tabindex='0' style='overflow: hidden; padding: 0px;' class='scroll-pane jspScrollable'>";
		echo "<div id='otherLikesBannerReal'><p id='otherBannerText'>People Who Like This </p><input type='submit' id='closeOtherLikes' onclick='closeOtherLikes();' value = 'x'></div>";
		

		for ($i=0; $i < count($otherPeopleIndivs); $i++) { 
			$queryTwo = "SELECT id, UserFirstName, UserLastName, Nickname FROM users WHERE id='$otherPeopleIndivs[$i]'";
			$resultTwo = mysqli_query($con, $queryTwo);
			while ($row = mysqli_fetch_array($resultTwo)) {
				if($i == 0){
					echo "<div id='firstIndivLikes'>";	
					echo "<a id='otherLikesNameLink' href='CheckFriends.php?id=" . $row['id'] . "'>".
						$row['UserFirstName'] . ' ' . $row['UserLastName'] . "</a>";
					echo "<span id='otherLikesNickname'>@" . $row['Nickname'] . "</span>";
					echo "</div>";
				}else{
					echo "<div id='indivLikes'>";	
					echo "<a id='otherLikesNameLink' href='CheckFriends.php?id=" . $row['id'] . "'>".
						$row['UserFirstName'] . ' ' . $row['UserLastName'] . "</a>";
					echo "<span id='otherLikesNickname'>@" . $row['Nickname'] . "</span>";
					echo "</div>";
				}
			}
		}

 ?>