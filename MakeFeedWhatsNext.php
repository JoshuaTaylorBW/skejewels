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
	$length = $_GET['length'];

	$query = "SELECT * FROM events WHERE Visibility='Public' AND UserID IN 
	('".$array."') AND BeginDateTime > DATE_SUB(NOW(), INTERVAL 15 MINUTE) 
	ORDER BY BeginDateTime LIMIT $length"
		OR DIE(mysqli_error());
	$result = mysqli_query($con, $query);
	$which = 0;//which box are we spawning

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
		 echo "<div id='FeedEvent' >
		 <a id='nameLink' href='CheckFriends.php?id=" . $row['UserID'] ."'>".
		  $row['UserFirstName'] . ' ' . $row['UserLastName'] ."</a></br>";
		  echo "<span id='feedNickname'>@" . $row['UserNickname'] . "</span>";


		  echo "</br><span id='eventInfo'> is going to  </span><span id='feedEventName'> " . $row['EventName'];
		  echo"</span><span id='feedEventDate'> on " . $dateTime->format('m-d');
		  echo"</span></br><span id='feedEventTime'>" . $dateTime->format('h:i A') . 
		  	' - ' . $endTime->format('h:i A') .  '</span></br>';


		  $indivs = explode(",", $row['LikedIds']);
		  for ($i=0; $i < count($indivs); $i++) { 
		  	if(intval($indivs[$i]) == $_SESSION['UserId']){
		  		$alreadyLiked = true;
		  	}
		  }

		  $realName = str_replace("'", "", $row['EventName']);

		  $vars = $row['id'] . ",\"". $realName  . "\",".$row['UserID'] .",". $which;
		  if($alreadyLiked){
		  	echo"<input id='LikeText' class= 'FeedEvent" . $which . "' type='submit'onclick='likeClicked(" . $vars .")' value='Unlike'></input></br>";
		  }else{
		  	echo"<input id='LikeText' class= 'FeedEvent" . $which . "' type='submit'onclick='likeClicked(" . $vars .")' value='Like'></input></br>";
		  }
		  	echo"<input id='CommentText' type='submit' onclick='showcomments(" . $row['id'] .")' value='Comment'></input></br>";


		if($row['CommentAmount'] == 0){
		 	 if($row['MostRecentLike'] == ""){
		 	 	if(intval($row['LikeAmount']) == 1){
				  echo"<span id='otherLikes'><input type='submit' id='otherLikesButton' onclick='otherLikes(" . $row['id'] . ")', value ='1 person'> likes this'></span>";
				}else if(intval($row['LikeAmount']) >= 2){
				  echo"<span id='otherLikes'><input type='submit' id='otherLikesButton' onclick='otherLikes(" . $row['id'] . ")', value ='" . intval($row['LikeAmount']) . " others'> like this</span>";
				}
		 	 }else{
		 	 	$recentIndivs = explode(" ", $row['MostRecentLike']);
				  if(intval($row['LikeAmount']) > 0){
				  	$n = rand(0,2);
				  	if($n > 1){
				  		if(intval($row['LikeAmount']) == 1){
				  			if($row['MostRecentLike'] == ""){
				  			}else{
					  			echo"<span id='otherLikes'><a href='CheckFriends.php?id=" . $recentIndivs[0] . "'>"
					  				 . $recentIndivs[1] . " " . $recentIndivs[2] . 
					  				"</a> likes this</span>";
					  		}
				  		}else{
				  			echo"<span id='otherLikes'><a href='CheckFriends.php?id=" . $recentIndivs[0] . "'>"
					  			 . $recentIndivs[1] . " " . $recentIndivs[2] .
					  				"</a> and<input type='submit' onclick='otherLikes(" . $row['id'] . ")', value ='" . intval($row['LikeAmount']-1) .
					  				 " others' id='otherLikesButton'>like this </span>" ;
				  		}
				  	}else{
				  		if(intval($row['LikeAmount']) == 1){
				  			echo"<span id='otherLikes'><input type='submit' id='otherLikesButton' onclick='otherLikes(" . $row['id'] . ")', value ='1 person'> likes this</span>";
				  		}else{
				  			echo"<span id='otherLikes'><input type='submit' id='otherLikesButton' onclick='otherLikes(" . $row['id'] . ")', value ='" . intval($row['LikeAmount']) . " people'> like this</span>";
				  		}
					}		  	
		 	 	}
		 	}
		}else{
			if(intval($row['LikeAmount']) == 0){
			  echo"<span id='otherLikes'><input type='submit' id='otherLikesButton' onclick='showcomments(" . $row['id'] . ")' value='" . $row['CommentAmount'] . " comments'></span>";
		 	}
			 if($row['MostRecentLike'] == ""){
		 	 	if(intval($row['LikeAmount']) == 1){
				  echo"<span id='otherLikes'><input type='submit' id='otherLikesButton' onclick='otherLikes(" . $row['id'] . ")', value ='1 person'> likes this and <input type='submit' id='otherLikesButton' onclick='showcomments(" . $row['id'] . ")' value='" . $row['CommentAmount'] . " comments'></span>";
				}else if(intval($row['LikeAmount']) >= 2){
				  echo"<span id='otherLikes'><input type='submit' id='otherLikesButton' onclick='otherLikes(" . $row['id'] . ")', value ='" . intval($row['LikeAmount']) . " others'> like this and <input type='submit' id='otherLikesButton' onclick='showcomments(" . $row['id'] . ")' value='" . $row['CommentAmount'] . " comments'></span>";
				}
		 	 }else{
		 	 	$recentIndivs = explode(" ", $row['MostRecentLike']);
				  if(intval($row['LikeAmount']) > 0){
				  	$n = rand(0,2);
				  	if($n > 1){
				  		if(intval($row['LikeAmount']) == 1){
				  			if($row['MostRecentLike'] == ""){//purely a check for opposite
				  			}else{
					  			echo"<span id='otherLikes'><a href='CheckFriends.php?id=" . $recentIndivs[0] . "')>"
					  				 . $recentIndivs[1] . " " . $recentIndivs[2] . 
					  				"</a> likes this and <input type='submit' id='otherLikesButton' onclick='showcomments(" . $row['id'] . ")' value='" . $row['CommentAmount'] . " comments'></span>";
					  		}
				  		}else{
				  			echo"<span id='otherLikes'><a href='CheckFriends.php?id=" . $recentIndivs[0] . "')>"
					  				 . $recentIndivs[1] . " " . $recentIndivs[2] . 
					  				"</a> and <input type='submit' onclick='otherLikes(" . $row['id'] . ")', value ='" . intval($row['LikeAmount']-1) .
					  				 " others' id='otherLikesButton'>like this and <input type='submit' id='otherLikesButton' onclick='showcomments(" . $row['id'] . ")' value='" . $row['CommentAmount'] . " comments'></span>";
				  		}
				  	}else{
				  		if(intval($row['LikeAmount']) == 1){
				  			echo"<span id='otherLikes'><input type='submit' id='otherLikesButton' onclick='otherLikes(" . $row['id'] . ")', value ='1 person'> likes this
				  			 and <input type='submit' id='otherLikesButton' onclick='showcomments(" . $row['id'] . ")' value='" . $row['CommentAmount'] . " comments'></span>";
				  		}else{
				  			echo"<span id='otherLikes'><input type='submit' id='otherLikesButton' onclick='otherLikes(" . $row['id'] . ")', value ='" . intval($row['LikeAmount']) . " people'> like this 
				  			and <input type='submit' id='otherLikesButton' onclick='showcomments(" . $row['id'] . ")' value='" . $row['CommentAmount'] . " comments'></span>";
				  		}
					}		  	
		 	 	}
		 	}
		}
		  echo'</div>';

		  $which++;
	}
	if(($length > 10 && $which === 10)){
		echo "<div id='LoadMore' >";
		echo "<p id='MoreFriendText'>Add more friends on Skejewels!!</p>";
		echo "</div>";
	}else{

		if($which % 10 === 0 && $which > 0){
			echo "<div id='LoadMore' >";
	    	echo"<input id='LoadMoreText' class= 'FeedEvent" . $which . "' type='submit'onclick='longerFeed();' value='Load More' ></input></br>";
			echo "</div>";
		}else{
			echo "<div id='LoadMore' >";
			echo "<p id='MoreFriendText'>Add more friends on Skejewels!!</p>";
			echo "</div>";
		}
	}

?>