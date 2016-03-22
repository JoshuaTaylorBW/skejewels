<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="NotFriends.css">
	<meta charset="UTF-8">
	<title>Skejewels</title>
		<link rel="icon" type="image/png" href="imgs/Favicon.png">

</head>
<body id="Body" onload="init()">
<input type="hidden" id="info" value="">

<div align="center" id="TextDiv">

<h1 id="Text" align="center"></h1>

</div>
<form id="DeclinedButton" onsubmit="JavaScript:Declined()" >
		<input id="GoHomeButton" type="submit" value="Decline Request" onclick="Declined()">
	</form>
	<form id="AcceptedButton" onSubmit="JavaScript:Added()" action="NewMain.php">
		<input id="AddAsFriendButton" type="submit" value="Add Friend">
	</form>
<script type="text/javascript">
	function init () {
		var str;
	str = "" + <?php echo json_encode($_GET["id"])?>;
	var res = str.split(" "); 

	document.getElementById("Text").innerHTML = res[1] + " Wants to be your friend!";
	document.getElementById("AddAsFriendButton").value = "Add \n" + res[1] + "\n as your friend!";
	}
	

	function Added () {
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			}
		}
	
		xmlhttp.open("GET","RequestAccepted.php?id=" + res[0], true);
		xmlhttp.send();

	}
	function Declined () {
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				window.alert(xmlhttp.responseText);

			}
		}
		xmlhttp.open("GET","RequestDeclined.php?id=" + res[0], true);
		xmlhttp.send();
		location.reload(true);
	}
</script>
	
	
	

<div id="BarBanner">
	<a href="NewMain.php" id="jewel">
		<img src="Jewel.png"  height="85%" border="0">
	</a>
	<input id="Search" type="text" placeholder="Search Skejewels" onkeyup="showResult(this.value)">
	
	<a href="addEvent.php" id="plus">
	<input id="AddButton" type="submit" value="+ Add Event +" onclick="AddEvent.php">
	</a>
	<div id="livesearch"></div>
</div>
</body>
</html>