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



// Friend Requests
$query = ("SELECT * FROM users WHERE id=$_SESSION['UserId']")	OR DIE(mysqli_error());
$result = mysqli_query($con,$query);
$hint = "";
while ($row = mysqli_fetch_array($result)) {
	$Requests = $row['RequestsFrom'];
	$Indivs = explode(",", $Requests);

	for ($i=0; $i <= count($Indivs); $i++) { 
		$query2 = ("SELECT * FROM users WHERE id=$Indivs");
		$result2 = mysqli_query($con, $query2);
		while($row2 = mysqli_fetch_array($result2)){
			if($hint === ""){
				$hint = "<a href='CheckFriends.php?id=" . $Indivs . "'>" . $row2['UserFirstName'] . ' ' . $row2['UserLastName'] . "</a>";
			}else{
				$hint = $hint .= "</br><a href='CheckFriends.php?id=" . $Indivs . "'>" . $row2['UserFirstName'] . ' ' . $row2['UserLastName'] . "</a>";				
			}
		}
	}

}

?>