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

$id = $_GET["id"]; // id from users page we are going to
$currUserId="".$_SESSION["UserId"];
$query = ("SELECT * FROM users WHERE id=$currUserId")	OR DIE(mysqli_error());
$result = mysqli_query($con,$query);
$moved = False;	//have we switched to new page yet?

while($row = mysqli_fetch_array($result)){
	$Requests = $row['RequestsFrom'];
	$Indivs = explode(",", $Requests);

	//get other users name and id
	$otherIndivs = explode("_", $id);
	$otherId = $otherIndivs[0];
	$otherName = $otherIndivs[1];

	for ($i=0; $i <= count($Indivs); $i++) { 
		if(intval(intval($Indivs[$i])) === intval($otherId)){
			header( 'Location: RequestsPage.php');
			$moved = True;
		}else{
			if($i === count($Indivs)){
				if(!$moved){
				header( 'Location: NotFriends.php?id='.$otherId .'_' . $otherName);

				}
			}
		}
	}

}


 ?>