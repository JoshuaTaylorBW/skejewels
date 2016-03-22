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

$nickname = trim(strtolower($_GET['nickname']));
$nickname = mysqli_escape_string($con, $nickname);

$query = "SELECT Nickname FROM users WHERE Nickname = '$nickname' LIMIT 1";
$result = $con->query($query);
$num = mysqli_num_rows($result);

if ( preg_match('/\s/',$nickname)){
	$num = 1;
}
echo $num;
mysqli_close($con);

?>