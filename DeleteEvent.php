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

$sql = "DELETE FROM events WHERE id='$id'";

if ($con->query($sql) === TRUE) {
} else {
    echo "Error deleting record: " . $con->error;
}

$con->close();
 ?>