<!DOCTYPE html>
<html>
<head>
	<title>Skejewels / Notifications</title>
	<link rel="stylesheet" type="text/css" href="NotificationsRequests.css">
	<link rel="stylesheet" href="BannerStyle.css">
	<link rel="stylesheet" href="AddEvents.css">
	<link rel="stylesheet" href="Others.css">
		<link rel="icon" type="image/png" href="imgs/Favicon.png">
		<script type="text/javascript" src="Parser.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>


</head>
<body id="Body" onload='init()'>
<script type="text/javascript">
	var Limit = 11;


	function init () {
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		ExitIt();
		makeNotifications();

	}

	$(document).ready(function(){
     $("#notifications-table-box").mouseover(function(){
			 $("#RequestsLogo").css("background-position", "0px 34px");
		   $("#requestText").css("color", "#FFD800");
     });
		 $("#notifications-table-box").mouseout(function () {
		 	$("#RequestsLogo").css("background-position", "0px 0px");
			$("#requestText").css("color", "white");
		 });
});

$(document).ready(function(){
	$("#request-table-box").mouseover(function(){
		$("#NotificationsLogo").css("background-position", "-29px 34px");
		$("#notificationText").css("color", "#FFD800");
		console.log("fuck");
	});
    $("#request-table-box").mouseout(function(){
		 $("#NotificationsLogo").css("background-position", "-29px 0px");
		 $("#notificationText").css("color", "white");
		 console.log("fuck");
   });

});

	//things regarding adding events.
		var parser = new Parser();
		function writeThis (name,startMonth, startDay, StartHour, StartMinute, StartingAMPM, EndMonth, EndDay, EndHour, EndMinute, EndAMPM, RepeatType, EndRepeatMonth, EndRepeatDay, Visibility) {
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

				//window.alert(startingHourReal + " " + endingHourReal);
				ExitIt();
				parser.add(name,startMonth, startDay, startingHourReal, StartMinute,EndMonth, EndDay, endingHourReal, EndMinute, RepeatType, EndRepeatMonth, EndRepeatDay, Visibility);
				MakeIt();
		}
		function hideIt () {
			document.getElementById("AddEvent").style.visibility="visible";
			document.getElementById('Dimmer').style.visibility="visible";
			document.getElementById("EventNameInput").value="";
			document.getElementById('RegVisibility').value = "Public";
			hideEndRepeats();
			window.scrollTo(0,0);

		}

		function notifyAmounts(){
			xmlhttp.onreadystatechange = function() {
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					if(xmlhttp.responseText == "noSession"){
						window.location.href = "Index.php";
					}else{
					document.getElementById('notifiers').innerHTML = xmlhttp.responseText;
					}
				}
			}

			xmlhttp.open("GET","NotificationsAmount.php", true);
			xmlhttp.send();
		}

		function showEndRepeats () {
				document.getElementById("EndRepeatDay").style.visibility="visible";
			document.getElementById("EndRepeatMonth").style.visibility="visible";
		}
		function hideEndRepeats(){
			document.getElementById("EndRepeatDay").style.visibility="hidden";
			document.getElementById("EndRepeatMonth").style.visibility="hidden";
		}
		function ExitIt () {
			document.getElementById("AddEvent").style.visibility="hidden";
			document.getElementById('Dimmer').style.visibility="hidden";
		}
		function setMonth (month1) {
			document.getElementById("EndingMonth").value = month1;
		}
		function setDay(day){
					document.getElementById("EndingDay").value = day;

		}
	//
	function showResult(str) {
	  if (str.length==0) {
	    document.getElementById("LiveSearch").innerHTML="";
	    document.getElementById("LiveSearch").style.border="0px";
	    return;
	  }
		xmlhttp.onreadystatechange=function() {
		   if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		     document.getElementById("LiveSearch").innerHTML=xmlhttp.responseText;
		   }
		 }
		 xmlhttp.open("GET","Search.php?q="+str,true);
		 xmlhttp.send();
	}

	function makeNotifications () {
	 	xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				document.getElementById('NotificationMessages').innerHTML = xmlhttp.responseText;
				notifyAmounts();

			}
		}
		xmlhttp.open("GET","NotificationBoxes.php?limit="+Limit, true);
		xmlhttp.send();
	 }
	 function longerNotifications () {
	 	Limit += 10;
	 	makeNotifications();
	 }

</script>

<div class="dim" id="Dimmer"  title="Event"></div>

<!--Banner is a fake banner to hold place and barbanner is where stuff is kept -->
<div id="Banner"></div>
<div id="BarBanner">
	<a href="NewMain.php" id="jewel">
		<img src="Jewel.png"  height="85%" border="0">
	</a>
	<input id="Search" type="text" placeholder="Search Skejewels" onkeyup="showResult(this.value)">

	<table id="Logos">
		<tr>
			<td class="table-elements" onclick="location.href='RequestsPage.php'" id="notifications-table-box">
				<div id="RequestsLogo"></div>
				<a href="RequestsPage.php" id="requestText" style="bottom: 12px;">Friend Requests</a>
			</td>
			<td class="table-elements" onclick="location.href='NotificationsPage.php'" id="request-table-box">
				<div id="NotificationsLogo"></div>
				<a href="NotificationsPage.php" id="notificationText" style="bottom: 12px;">Notifications</a>
			</td>
		</tr>
	</table>

	<button type="button" id="AddButton" onclick="hideIt()">+ Add Event +</button>

	<div id="notifiers"></div>
		<div id="LiveSearch"></div>
	</div>
</div>

<div id="NotificationList">
	<div id="Notes" align="center">
	<div id="NotificationBanner">
		<p id="BannerText">Notifications:</p>
	</div>
	<div id="NotificationMessages">

	</div>

	</div>
</div>

<div id="AddEvent">
	<input type="text" id="EventNameInput" align="center" placeholder="Event Name">
		<span id="StartingDates">Starting Date: </span>

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

	<select id="EndingDay" placeholder="Ending Day... January">
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

		<span id="StartingTimes">Starting Time: </span>
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

		<span id="RepeatText">Repeat:</span>
		<select id="RepeatType">
			<option value="Once" onclick="hideEndRepeats();">Once</option>
			<option value="Weekly" onclick="showEndRepeats();">Weekly</option>
			<option value="Monthly" onclick="showEndRepeats();">Monthly</option>
		</select>
		<!-- End repeat selects -->
		<select id="EndRepeatMonth">
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


	<select id="EndRepeatDay">
	<!-- Ask user for day -->
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
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
		<!---->
	<select id="RegVisibility">
			<option value="Public">Public</option>
			<option value="Private">Private</option>
			<option value="Busy">Busy</option>
		</select>
	<input type="button" id="AddEventButton"
				 value="Add To Skejewel"
				  onclick="
				  writeThis(
				  		document.getElementById
				  		('EventNameInput').value,
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
				  		('EndingAMPM').value,
				  		document.getElementById
				  		('RepeatType').value,
				  		document.getElementById
				  		('EndRepeatMonth').value,
				  		document.getElementById
				  		('EndRepeatDay').value,
				  		document.getElementById
				  		('RegVisibility').value);
				  		this.disabled=true;


				  		"
					>


		<button id="Exit" onclick="ExitIt();">x</button>
</div>

</body>
</html>
