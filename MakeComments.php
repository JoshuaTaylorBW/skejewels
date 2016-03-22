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

$EventId = $_GET['EventId'];

$query = "SELECT * FROM Comments WHERE CommentStatusId = '$EventId' ORDER BY CommentId ASC";
$result = mysqli_query($con, $query);
echo "<div tabindex='0' style='overflow: hidden; padding: 0px;' class='scroll-pane jspScrollable'>";
$amount = 0;
while ($row = mysqli_fetch_array($result)){
	echo "<div id='Comment'>"; //start comment div
	echo "<div id='info'>"; //start info div
	echo "<a id='commentName' href='checkFriends.php?id=" . $row['CommenterId'] . "'><b>" . $row['CommenterName'] . "</b></a>";
	echo "<span id=CommentNickname><small>@" . $row['CommenterNickname'] . "</small></span>";
	echo "</div>";//ends info div
	echo "<div id='Words'>";//begin word div
	echo "<span id='CommentWords'>" . $row['Comment'] . "</span>";
	echo "</div>";//ends word div
	echo "</div>";//end comment div
	$amount++;
	}
	echo "<div id='finished' onload='resizeComment(" . $amount . ")'></div>";
 ?>