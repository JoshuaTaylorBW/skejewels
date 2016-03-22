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

$query = ("SELECT * FROM events WHERE UserID=1") OR DIE(mysqli_error());
$result = mysqli_query($con, $query);

$names="";

while($row = mysqli_fetch_array($result)){
	if(count($names) == 0){
		$names = $row['EventName'] . ",";
	}else{
		$names .= $row['EventName'] . ",";		
	}
}

print(json_encode($names));
mysql_close();

 ?>