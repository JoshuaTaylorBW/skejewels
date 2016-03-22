<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "skejewel";

$con=new mysqli($servername,$username,$password, $dbname);
if($con->connect_error){
	die("connection failed" . $con->connect_error);
}

mysqli_select_db($con, "skejewel");

//get the q parameter from URL
$q=$_GET["q"];

$query = ("SELECT * FROM users")	OR DIE(mysqli_error());
$result = mysqli_query($con,$query);

$hint ="";

function clean($string) {
   $string = str_replace(' ', ' ', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
$total = 0;//total is the amount of results weve created
if(strlen($q)>0){
	$q = strtolower($q);
    $len=strlen($q);
    while($row = mysqli_fetch_array($result)){
	    $n = $row['UserFirstName'];
	    $nn = $row['Nickname'];
	    $real = clean($q);
	    if($total < 7){
	    	if(stristr($q, substr($n, 0, $len)) || stristr($real, substr($nn, 0, $len))){
	    		if($hint === ""){
	    			$hint = "<a id='searchName' href='CheckFriends.php?id=" . $row['id'] . "'>" . '@' . $nn . ' - ' . $n . ' ' . $row['UserLastName'] . "</a>";
	    			$total++;
	    		}else{
	    			$hint = $hint .= "<br><a id='searchName' href='CheckFriends.php?id=" . $row['id'] . "'>" . '@' . $nn . ' - ' . $n . ' ' . $row['UserLastName'] . "</a>";
	    			$total++;
	    		}
	    	}
		}
	}
}
echo $hint === "" ? "no suggestion" : $hint;
 ?>
