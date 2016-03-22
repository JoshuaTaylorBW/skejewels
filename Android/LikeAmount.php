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

$query = ("SELECT * FROM events WHERE id='$id' AND UserID=1") OR DIE(mysqli_error());
$result = mysqli_query($con, $query);

$likeAmount = ",";

while($row = mysqli_fetch_array($result)){
	$likeAmount .= $row['LikeAmount'] . ",";
	$likeAmount .= $row['CommentAmount'] . ",";
}

print(json_encode($likeAmount));
mysql_close();

 ?>