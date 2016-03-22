<!DOCTYPE html>
<html>
<head>
	<title>Schejewel(Version:0.01)</title>
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<link rel="stylesheet" type="text/css" href="Style.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="Parser.js"></script>
				  
	<a href="NewMain.php" id="jewel">
		<img src="Jewel.png" width="111" height="99" border="0">
	</a>

<script type="text/javascript">

	var parser = new Parser();

	function writeThis (name,startMonth, startDay, StartHour, StartMinute, StartingAMPM, EndMonth, EndDay, EndHour, EndMinute, EndAMPM) {
		var startingHourReal = parseInt(StartHour, 10);
		var endingHourReal = parseInt(EndHour, 10);
		if (StartingAMPM == "PM") {startingHourReal += 12};
		if (EndAMPM == "PM") {endingHourReal += 12};

		if(StartHour == 12 && StartingAMPM == "AM"){
			startingHourReal -= 12
		};
		if(EndHour == 12 && EndAMPM == "AM"){
			endingHourReal -= 12
		};

		parser.add(name,startMonth, startDay, startingHourReal, StartMinute,EndMonth, EndDay, endingHourReal, EndMinute);
}

	function setMonth (month) {
		document.getElementById("EndingMonth").value = month;
	}
	function setDay(day){
				document.getElementById("EndingDay").value = day;

	}

	</script>
</head>


<body>
	<!-- ask for the user to put in the name of the event-->

		

	<div id="Names" align="center">
	<p align="center">Event Name:</p>
	 <input id="EventName" text-align:center; type="text" name="fname" size="60">
	</div>
<div id="Selects">
	<div id="Dates" align="center">
		<span><br>Starting Date: </span>
	
		<select id="StartingMonth" onchange="setMonth(this.value);">
		<!-- Ask user for month -->
			<option value="01">January</option>
			<option value="02">February</option>
			<option value="03">March</option>
			<option value="04">April</option>
			<option value="05">May</option>
			<option value="06">June</option>
			<option value="07">July</option>
			<option value="08">August</option>
			<option value="09">September</option>
			<option value="10">October</option>
			<option value="11">November</option>
			<option value="12">December</option>
		</select>
	

	<select id="StartingDay" onchange="setDay(this.value);">
	<!-- Ask user for day -->
			<option value="01">1</option>
			<option value="02">2</option>
			<option value="03">3</option>
			<option value="04">4</option>
			<option value="05">5</option>
			<option value="06">6</option>
			<option value="07">7</option>
			<option value="08">8</option>
			<option value="09">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
			<option value="24">24</option>
			<option value="25">25</option>
			<option value="26">26</option>
			<option value="27">27</option>
			<option value="28">28</option>
			<option value="29">29</option>
			<option value="30">30</option>
			<option value="31">31</option>
		</select>


	<span id="EndingDates">Ending Date: </span>
	<select id="EndingMonth">
	<!-- Ask user for month -->
			<option value="01">January</option>
			<option value="02">February</option>
			<option value="03">March</option>
			<option value="04">April</option>
			<option value="05">May</option>
			<option value="06">June</option>
			<option value="07">July</option>
			<option value="08">August</option>
			<option value="09">September</option>
			<option value="10">October</option>
			<option value="11">November</option>
			<option value="12">December</option>
		</select>

	<select id="EndingDay">
	<!-- ask user for day event ends !-->
			<option value="01">1</option>
			<option value="02">2</option>
			<option value="03">3</option>
			<option value="04">4</option>
			<option value="05">5</option>
			<option value="06">6</option>
			<option value="07">7</option>
			<option value="08">8</option>
			<option value="09">9</option>
			<option value="10">10</option>
			<option value="11">11</option>
			<option value="12">12</option>
			<option value="13">13</option>
			<option value="14">14</option>
			<option value="15">15</option>
			<option value="16">16</option>
			<option value="17">17</option>
			<option value="18">18</option>
			<option value="19">19</option>
			<option value="20">20</option>
			<option value="21">21</option>
			<option value="22">22</option>
			<option value="23">23</option>
			<option value="24">24</option>
			<option value="25">25</option>
			<option value="26">26</option>
			<option value="27">27</option>
			<option value="28">28</option>
			<option value="29">29</option>
			<option value="30">30</option>
			<option value="31">31</option>
		</select>

	</div>
	
		<span><br>Starting Time: </span>
		<select id="StartingHour" name="Starting_Hour">
		<!-- ask the user for the hour the event starts -->
			  <option value="01">1</option>
			  <option value="02">2</option>
			  <option value="03">3</option>
			  <option value="04">4</option>
			  <option value="05">5</option>
			  <option value="06">6</option>
			  <option value="07">7</option>
			  <option value="08">8</option>
			  <option value="09">9</option>
			  <option value="10">10</option>
			  <option value="11">11</option>
			  <option value="12">12</option>
			</select> 
		<span> : </span>
		<select id="StartingMinute" name="Starting_Minute">
		<!-- ask the user for the minute the event starts -->
			  <option value="00">00</option>
			  <option value="05">05</option>
			  <option value="10">10</option>
			  <option value="15">15</option>
			  <option value="20">20</option>
			  <option value="25">25</option>
			  <option value="30">30</option>
			  <option value="35">35</option>
			  <option value="40">40</option>
			  <option value="45">45</option>
			  <option value="50">50</option>
			  <option value="55">55</option>
		</select> 
		<select id="StartingAMPM" name="StartingAMPM">
				<option value="AM">AM</option>
				<option value="PM">PM</option>
			</select>

		<span id="EndingTimes">Ending Hour: </span>
		<select id="Ending_Hour">
			<!-- ask the user for the hour the event ends -->
			  <option value="01">1</option>
			  <option value="02">2</option>
			  <option value="03">3</option>
			  <option value="04">4</option>
			  <option value="05">5</option>
			  <option value="06">6</option>
			  <option value="07">7</option>
			  <option value="08">8</option>
			  <option value="09">9</option>
			  <option value="10">10</option>
			  <option value="11">11</option>
			  <option value="12">12</option>
			</select> 
		<span> : </span>
		<select id="Ending_Minute">
			<!-- ask the user for the minute the event ends -->
			  <option value="00">00</option>
			  <option value="05">05</option>
			  <option value="10">10</option>
			  <option value="15">15</option>
			  <option value="20">20</option>
			  <option value="25">25</option>
			  <option value="30">30</option>
			  <option value="35">35</option>
			  <option value="40">40</option>
			  <option value="45">45</option>
			  <option value="50">50</option>
			  <option value="55">55</option>
		</select> 
		<select id="EndingAMPM" name="EndingAMPM">
				<option value="AM">AM</option>
				<option value="PM">PM</option>
		</select>
	</div>

</div>
		<div id="Submit" align="center">
			<br></br>
				<input type="button" id="submitter"
				 value="Add To Schejewel"
				  onclick="
				  writeThis(
				  		document.getElementById
				  		('EventName').value,
				  		document.getElementById
				  		('StartingMonth').value,
				  		document.getElementById
				  		('StartingDay').value,
				  		document.getElementById
				  		('StartingHour').value,
				  		document.getElementById
				  		('StartingMinute').value,
				  		document.getElementById
				  		('StartingAMPM').value,
				  		document.getElementById
				  		('EndingMonth').value,
				  		document.getElementById
				  		('EndingDay').value,
				  		document.getElementById
				  		('Ending_Hour').value,
				  		document.getElementById
				  		('Ending_Minute').value,
				  		document.getElementById
				  		('EndingAMPM').value)
				  		"
					>
		
</body>



</html>