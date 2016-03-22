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

include 'functions.php';

if(isset($_SESSION['Username']) || isset($_COOKIE["cookies"]['UserId'])) {
	echo "Go";
	createVariables();
}else{
	echo "Stop";
}

 ?>