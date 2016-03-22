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

$m = $_GET['m'];

$query = ("SELECT * FROM events
 WHERE EXTRACT(MONTH FROM BeginDateTime) = $m AND UserID='1' ORDER BY BeginDateTime")
OR DIE(mysqli_error());
$result = mysqli_query($con,$query);



echo "<table >
<tr>
<th>Day</th>
<th>Time</th>
<th>What </th>
</tr>";

while($row = mysqli_fetch_array($result)){
	$dateTime = new DateTime($row['BeginDateTime']);
	$endTime = new DateTime($row['EndDateTime']);
	echo "<tr>";
  	 echo "<td align='center' >" . $dateTime->format('F') . ' ' . $dateTime->format('d') .  "</td>";
  	 echo "<td align='center' width= '400px'>" . $dateTime->format('h') . ':' . $dateTime->format('i') . ' ' . $dateTime->format('A') . ' - '
  								. $endTime->format('h') . ':' . $endTime->format('i') . ' ' . $endTime->format('A');
	 echo "<td align='center' width='600px'>"  . $row['EventName'] . "</td>";

  	 echo "</tr>";
}
echo "</table>";
mysqli_close($con);

 ?>