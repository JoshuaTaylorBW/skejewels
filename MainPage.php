<!DOCTYPE html>
<html>
<head>
	<title>Skejewel</title>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<link rel="stylesheet" type="text/css" href="MainStyle.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="Schedule.js"></script>
				  
	<a href="NewMain.php" id="jewel">
		<img src="Jewel.png" width="111" height="99" border="0">
	</a>
	<a href="addEvent.php" id="plus">
		<img src="Plus.png" width="50" height="50" border="0">
	</a>

	<script type="text/javascript">
		var month = 0;//this is the current month we are displaying
		var sced = new Schedule();
		var months = ["January", "February", "March", "April", "May",
						"June", "July", "August", "September",
						"October", "November", "December"];
		function nextMonth () {
			if(month < 12){
				month++;
			}else{
				month = 1;
			}
			sced.makeTable('Events', month);
			document.getElementById('Month').innerHTML = months[month - 1];
		}
		function previousMonth () {
			if(month > 1){
				month--;
			}else{
				month = 12;
			}
			sced.makeTable('Events', month);
			document.getElementById('Month').innerHTML = months[month - 1];
		}

		
	</script>

</head>
<body onload="nextMonth()">

<input id="NextMonthButton" type="submit" onclick="nextMonth();" value="Next Month">
<input id="PreviousMonthButton" type="submit" onclick="previousMonth();" value="Previous Month">

<p id="Month" align="center">January</p>
<hr noshade></hr>
<div id="Events"><p><b>The month's events will be listed here...</b></p></div>


</body>
</html>