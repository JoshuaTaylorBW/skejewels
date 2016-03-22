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
$q=$_GET["q"];
$name_search = "+" . str_replace(" ", "+", $q);


$query = "SELECT * FROM users WHERE MATCH(UserFirstName, UserLastName) AGAINST('$name_search*' IN BOOLEAN MODE) OR NICKNAME LIKE '%$q%'"
	OR DIE(mysqli_error());
	$result = mysqli_query($con,$query);

    while($row = mysqli_fetch_array($result)){

	    $n = $row['UserFirstName'] . " " . $row['UserLastName'];
	    $nn = $row['Nickname'];
			$id = $row['id'];
  			$hint .= "," . $id . "," . $n . ',' . $nn . ',';
	}

	print(json_encode($hint));
	print("\n");
	print("searching for" . $name_search);
	print("and for" . $query);



 ?>
