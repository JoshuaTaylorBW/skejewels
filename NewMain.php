


<!DOCTYPE html>
<html>
<head>
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'><!-- import Roboto font -->
	<title>Skejewels</title>
	<link rel="stylesheet" href="Feed.css">
	<link rel="stylesheet" href="Others.css">
	<link rel="stylesheet" href="EditEvents.css">
	<link rel="stylesheet" href="AddEvents.css">
	<link rel="stylesheet" href="CommentsBox.css">
	<link rel="stylesheet" href="Calendar.css">
	<link rel="stylesheet" href="OtherLikesBox.css">
	<link rel="stylesheet" type="text/css" href="script/jquery.jscrollpane.css" media="all"/>
	<link rel="stylesheet" href="BannerStyle.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<link rel="icon" type="image/png" href="imgs/Favicon.png">
		<script type="text/javascript" src="Parser.js"></script>
<!-- the mousewheel plugin - optional to provide mousewheel support -->
<script type="text/javascript" src="script/jquery.mousewheel.js"></script>

<!-- the jScrollPane script -->
<script type="text/javascript" src="script/jquery.jscrollpane.min.js"></script>

<!-- <div id="background-wrap">
	<div id="bg">
		<img src="Background/Background.png" alt="">
	</div>
</div> -->

<script type="text/javascript">
	var d = new Date();
	var n = d.getMonth();
	var y = d.getFullYear();
	var Month = n + 1; //this is the current month. the one we're displaying.
	var year = y;
	var months = ["January", "February", "March", "April", "May",
						"June", "July", "August", "September",
						"October", "November", "December"];

	var parser = new Parser();
	var editEventId = -1;


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


	function edit(id){
		var editInfo = "";
		var splitVar = " ^?~-~?) ";

		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				document.getElementById("EditEvent").style.visibility="visible";
				document.getElementById('Dimmer').style.visibility="visible";

				editInfo = xmlhttp.responseText;
				var indivs = editInfo.split(splitVar);
				editEventId = id;
				//change values of selects in the edit options screen.
				document.getElementById("EditEventNameInput").value = indivs[0];
				document.getElementById("EditStartingMonth").value = indivs[1];
				document.getElementById("EditStartingDay").value = indivs[2];
				document.getElementById("EditStartingHour").value = indivs[3];
				document.getElementById("EditStartingMinute").value = indivs[4];
				document.getElementById("EditStartingAMPM").value = indivs[5];
				document.getElementById("EditEndingMonth").value = indivs[6];
				document.getElementById("EditEndingDay").value = indivs[7];
				document.getElementById("EditEnding_Hour").value = indivs[8];
				document.getElementById("EditEnding_Minute").value = indivs[9];
				document.getElementById("EditEndingAMPM").value = indivs[10];
			}
		}

		xmlhttp.open("GET","EditEventParse.php?eventId=" + id, true);
		xmlhttp.send();
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
	function editThis (name,startMonth, startDay, StartHour, StartMinute, StartingAMPM, EndMonth, EndDay, EndHour, EndMinute, EndAMPM, Visibility) {
		var startingHourReal = parseInt(StartHour, 10);
		var endingHourReal = parseInt(EndHour, 10);
		if (StartingAMPM == "PM" && StartingHour != 12) {startingHourReal += 12};
		if (EndAMPM == "PM" && StartingHour != 12) {endingHourReal += 12};
		if(StartHour == 12 && StartingAMPM == "AM"){
		startingHourReal -= 12
		};
		if(EndHour == 12 && EndAMPM == "AM"){
		endingHourReal -= 12
		};

		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

				hideEdit();
				MakeIt();
			}
		}
		xmlhttp.open("GET","SQLEdit.php?id="+editEventId+"&n="+name+"&sM="+startMonth+"&sD="+startDay+"&sH="+startingHourReal
			+"&sMi="+StartMinute+"&eM="+EndMonth+"&eD="+EndDay+"&eH="+endingHourReal+"&eMi="+EndMinute+
			"&v="+Visibility
			,true);
		xmlhttp.send();
	}
	function deleteThis () {
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				hideEdit();
				MakeIt();
			}
		}

		xmlhttp.open("GET","DeleteEvent.php?id=" + editEventId, true);
		xmlhttp.send();
	}
	function hideEdit () {
		document.getElementById("EditEvent").style.visibility="hidden";
		document.getElementById('Dimmer').style.visibility="hidden";
	}
	function writeThis (name,startMonth, startDay, StartHour, StartMinute, StartingAMPM, EndMonth, EndDay, EndHour, EndMinute, EndAMPM, RepeatType, EndRepeatMonth, EndRepeatDay, Visibility) {
			var startingHourReal = parseInt(StartHour, 10);
			var endingHourReal = parseInt(EndHour, 10);
			if (StartingAMPM == "PM") {startingHourReal += 12;}
			if (EndAMPM == "PM") {endingHourReal += 12;}

			if(StartHour == 12 && StartingAMPM == "AM"){
				startingHourReal -= 12;
			}
			if(EndHour == 12 && EndAMPM == "AM"){
				endingHourReal -= 12;
			}
			if(StartHour == 12 && StartingAMPM == "PM"){
				startingHourReal = 12;
			}
			if(EndHour == 12 && EndAMPM == "PM"){
				endingHourReal = 12;
			}
			xmlhttp.onreadystatechange = function() {
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					ExitIt();
					MakeIt();
				}
			}
			xmlhttp.open("GET","SQLAdd.php?n="+name+"&sM="+startMonth+"&sD="+startDay+"&sH="+startingHourReal
				+"&sMi="+StartMinute+"&eM="+EndMonth+"&eD="+EndDay+"&eH="+endingHourReal+"&eMi="+EndMinute+"&rT="
				+RepeatType+"&eRM="+EndRepeatMonth+"&eRD="+EndRepeatDay+"&v="+Visibility, true);

			xmlhttp.send();
	}
	function checkLogged () {
		if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
					if(xmlhttp.responseText == "Go"){
						MakeIt();

					}else{
						log(xmlhttp.responseText);
						window.location="index.php";
					}
				}
			}

			xmlhttp.open("GET","CheckLoggedIn.php", true);

			xmlhttp.send();
	}
	function MakeIt(){
		document.getElementById('AddEvent').style.visibility="hidden";
		document.getElementById('EditEvent').style.visibility="hidden";
		document.getElementById('Dimmer').style.visibility="hidden";
		document.getElementById('OtherLikes').style.visibility="hidden";
		document.getElementById('Comments').style.visibility="hidden";
		document.getElementById('writingSection').style.visibility="hidden";

		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

				 document.getElementById('TheCalendar').innerHTML = xmlhttp.responseText;
				 document.getElementById('MonthName').innerHTML = months[Month - 1];
				 makeWhatsNextFeed();
				 $(document).ready(function(){
					var cw = $('#CalendarTable').height();
					var ch = $('#calendarBorder').width();
					$('#calendarBorder').css({'height': (cw - 5) +'px'});
					$('#calendarBorder').css({'width': (ch-3) +'px'});
					$('#TheCalendar').css({'width':(ch)+'px; table-layout:fixed;'});
				});
			}
		}

		console.log(year);

		xmlhttp.open("GET","MakeCalendar.php?Month=" + Month + "&Year=" + year, true);
		xmlhttp.send();
	}
	function likeClicked (eventId, eventName, UserId, whichEvent) {
		$(document).ready(function(){
				if($(".FeedEvent"+whichEvent).val() == "Like"){
					$(".FeedEvent"+whichEvent).val("Unlike");
					like(eventId, eventName, UserId);
				}else{
					$(".FeedEvent"+whichEvent).val("Like");
					unlike(eventId);
				}

		});
	}
	function like (eventId, eventName, UserId) {//likes the status with the eventId
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			}
		}
		xmlhttp.open("GET","Like.php?eventId="+eventId+"&eventName="+eventName+"&UserId="+UserId, true);
		xmlhttp.send();
	}
	function unlike(eventId){

		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			}
		}
		xmlhttp.open("GET","Unlike.php?eventId=" + eventId, true);
		xmlhttp.send();
	}
	function otherLikes (eventId) {
		document.getElementById("OtherLikes").style.visibility="visible";
		document.getElementById('Dimmer').style.visibility="visible";
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				document.getElementById("OtherLikes").innerHTML = xmlhttp.responseText;
				$(document).ready(function(){
					$('#OtherLikes').jScrollPane(
						{
							showArrows: true,
							verticalDragMinHeight: 20,
							verticalDragMaxHeight: 40						});
					$(document).find('.jspPane').css('width','332px');

					$(document).find('.jspContainer').css('height','381px');
					$(document).find('#Body').css('overflow', 'hidden');
				});
			}
		}

		xmlhttp.open("GET","MakeOtherLikes.php?EventId=" + eventId, true);
		xmlhttp.send();
	}
	function closeOtherLikes () {
		location.reload();
	}
	var commentEventId = -1;// The id of the event that we are viewing the comments for.

	$(function() {
   		$("#commentWriter").keypress(function (e) {
        	if(e.which == 13) {
            	//submit form via ajax, this is not JS but server side scripting so not showing here
            	AddComment($(this).val());
           		 $(this).val("");
           		 e.preventDefault();
	        }
	    });
	});
	function showcomments (eventId) {
		document.getElementById("Comments").style.visibility="visible";
		document.getElementById('Dimmer').style.visibility="visible";
		document.getElementById('writingSection').style.visibility="visible";
		log(eventId);
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				document.getElementById("Comments").innerHTML += xmlhttp.responseText;
				commentEventId = eventId;
				$(document).ready(function(){
					$('#Comments').jScrollPane(
					{
						verticalDragMinHeight: 40,
							verticalDragMaxHeight: 10000
						}	);

					$(document).find('.jspPane').css('width','892px');


					$(document).find('.jspContainer').css('height','100%');
					$(document).find('#Body').css('overflow', 'hidden');

					$(document).find('.jspCap.jspCapTop').css('height','00px');
					$(document).find('.jspTrack').css('height', '420px')
				});
			}
		}
		xmlhttp.open("GET","MakeComments.php?EventId=" + eventId, true);
		xmlhttp.send();
	}
	function hideComments () {
		location.reload();
	}
	function resizeComment (amount) {
		$(document).ready(function(){
			var heightResize = amount * 85;
			$( "#CommentContainer" ).css("height","595px" );
		});
		log('maybe');
	}

	function AddComment (commentVal) {
		log(commentVal + ' ' + commentEventId);
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				hideComments();
			}
		}
		xmlhttp.open("GET","NewComment.php?statusId=" + commentEventId + "&comment=" + commentVal, true);
		xmlhttp.send();

	}
	var feedLength = 10;
	function makeWhatsNextFeed () {
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				 document.getElementById('UpdatesMessages').innerHTML = xmlhttp.responseText;
					notifyAmounts();
				}
		}
		xmlhttp.open("GET","MakeFeedWhatsNext.php?length=" + feedLength, true);
		xmlhttp.send();
	}
	function longerFeed () {
		feedLength += 6;
		makeWhatsNextFeed();
	}
	function makeEventsCreatedFeed () {
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
				 document.getElementById('UpdatesMessages').innerHTML = xmlhttp.responseText;

				}
		}
		xmlhttp.open("GET","MakeFeedWhatsScheduled.php", true);
		xmlhttp.send();
	}
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
	function NextMonth () {
		if(Month < 12){
			Month++;

		}else{
			Month = 1;
			year++;
		}
		MakeIt();
	}
	function PreviousMonth () {
		if(Month > 1){
			Month--;
		}else{
			Month = 12;
			year--;
		}
		MakeIt();
	}
	function hideIt () {
		document.getElementById("AddEvent").style.visibility="visible";
		document.getElementById('Dimmer').style.visibility="visible";
		document.getElementById("EventNameInput").value="";
		document.getElementById('RegVisibility').value = "Public";
		hideEndRepeats();
		window.scrollTo(0,0)
		document.getElementById('AddEventButton').disabled = false;
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
	function setEditMonth(month1){
		document.getElementById("EditEndingMonth").value = month1;
	}
	function setEditDay (day) {
		document.getElementById("EditEndingDay").value = day;
	}
	function setHour (hour) {
		document.getElementById("Ending_Hour").value = hour;
	}
	function setMinute (minute) {
		document.getElementById("Ending_Minute").value = minute;
	}
	function setEditHour (hour) {
		document.getElementById("EditEnding_Hour").value = hour;
	}
	function setEditMinute (minute) {
		document.getElementById("EditEnding_Minute").value = minute;
	}
	function setAmpm (ampm) {
		if(document.getElementById("EditStartingAMPM").value == "AM"){
			document.getElementById("EndingAMPM").value = "PM";

		}
	}
	function setEditAmPm (ampm) {
			document.getElementById("EditEndingAMPM").value = "PM";
	}
	function hideEndRepeats(){
		document.getElementById("EndRepeatDay").style.visibility="hidden";
		document.getElementById("EndRepeatMonth").style.visibility="hidden";
	}
	function showEndRepeats () {
			document.getElementById("EndRepeatDay").style.visibility="visible";
		document.getElementById("EndRepeatMonth").style.visibility="visible";
	}
</script>
</head>
<body id="Body" onload="checkLogged()">
<!-- <div id="calendarBorder"></div> -->
<div id="Banner">
	<div id="CalendarMonth">
		<h1 id="MonthName" align="center"></h1>

			<img src="RightArrow.png"  height="35%" border="0" id="RightArrow" style="cursor:pointer" onclick="NextMonth()">

			<img src="LeftArrow.png"  height="35%" border="0" id="LeftArrow" style="cursor:pointer" onclick="PreviousMonth()">

	</div>

	<div id="CalendarTable" align="center">
	<table style="width:100%;" id="DaysOfWeek">
		<table id="TheCalendar">
			</table>

	</div>
	<div id="Feed">


		<div id="Updates" align="center">
			<!-- <input type='submit' id="FeedTypeSelect" value="Whats Happening Now" onclick="makeWhatsNextFeed()">
			<input type='submit' id="FeedTypeSelect" value="Whats Being Scheduled" onclick="makeEventsCreatedFeed()">
			 --><div id="UpdatesMessages">

		</div>
		<a id="logoutText" href="Logout.php">Logout</a>
		<a id="recognitionText" href="Recognition.php" style="color:white;">Recognition</a>
	</div>
		<!-- <div id="Recommend1">
			<h2 align="center">This will recommend events and friends</h2>
		</div>
		<div id="Recommend2">

			<h2 align="center">This will recommend events and friends</h2>
		</div> -->
	</div>

</div>

<div class="dim" id="Dimmer"  title="Event">
</div>

<div id="AddEvent">
	<input type="text" id="EventNameInput" align="center" placeholder="Event Name">
		<span id="StartingDates">Start Date: </span>

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
		<select id="StartingHour" name="Starting_Hour" onchange="setHour(this.value);">
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

		<select id="StartingMinute" name="Starting_Minute" onchange="setMinute(this.value);">
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
		<select id="StartingAMPM" name="StartingAMPM" onchange="setAmpm(this.value);">
				<option value="AM">AM</option>
				<option value="PM">PM</option>
			</select>

		<span id="EndingTimes">End Time: </span>
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
<div id="EditEvent">
	<input type="text" id="EditEventNameInput" align="center" placeholder="Event Name">
		<span id="StartingDates">Start Date: </span>

	<select id="EditStartingMonth" onchange="setEditMonth(this.value);">
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


	<select id="EditStartingDay" onchange="setEditDay(this.value);">
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
	<span id="EditEndingDates">Ending Date: </span>
		<select id="EditEndingMonth">
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

	<select id="EditEndingDay" placeholder="Ending Day... January">
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

		<span id="EditStartingTimes">Starting Time: </span>
		<select id="EditStartingHour" name="Starting_Hour">
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

		<select id="EditStartingMinute" name="Starting_Minute">
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
		<select id="EditStartingAMPM" name="StartingAMPM" onchange="setEditAmPm(this.value);">
				<option value="AM">AM</option>
				<option value="PM">PM</option>
			</select>

		<span id="EditEndingTimes">End Time: </span>
		<select id="EditEnding_Hour">
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

		<select id="EditEnding_Minute">
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
		<select id="EditEndingAMPM" name="EndingAMPM">
				<option value="AM">AM</option>
				<option value="PM">PM</option>
		</select>

		<input id="EditRepeatType" type="submit" value="Delete Event" onclick="deleteThis()">
	<select id="Visibility">
			<option value="Public">Public</option>
			<option value="Private">Private</option>
			<option value="Busy">Busy</option>
		</select>
	<input type="button" id="EditEventButton"
				 value="Edit Event"
				  onclick="
				  editThis(
				  		document.getElementById
				  		('EditEventNameInput').value,
				  		document.getElementById
				  		('EditStartingMonth').value,
				  		document.getElementById
				  		('EditStartingDay').value,
				  		document.getElementById
				  		('EditStartingHour').value,
				  		document.getElementById
				  		('EditStartingMinute').value,
				  		document.getElementById
				  		('EditStartingAMPM').value,
				  		document.getElementById
				  		('EditEndingMonth').value,
				  		document.getElementById
				  		('EditEndingDay').value,
				  		document.getElementById
				  		('EditEnding_Hour').value,
				  		document.getElementById
				  		('EditEnding_Minute').value,
				  		document.getElementById
				  		('EditEndingAMPM').value,
				  		document.getElementById
				  		('Visibility').value);
				  		"
					>
		<button id="Exit" onclick="hideEdit();">x</button>

	</div>
</div>
<div id="OtherLikes">
</div>
<div id="Comments">

	<div id="CommentBanner">
	</div>

</div>
<div id="writingSection">
	<textarea id="commentWriter" placeholder="Write a comment..." maxlength="240"></textarea>
	<input type="sumbit" value="x" onclick="hideComments();" id="CommentExitButton">

</div>
	<div id="BarBanner">
	<a href="NewMain.php" id="jewel">
		<img src="Jewel.png" height="85%" border="0">
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


	<button type="button" id="AddButton" onclick="hideIt(); this.disabled=false;">+ Add Event +</button>
<div id="notifiers"></div>
	<div id="LiveSearch"></div>
</div>


</body>
</html>
