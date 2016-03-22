<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="Feed.css">
	<link rel="stylesheet" href="Others.css">
	<link rel="stylesheet" href="EditEvents.css">
	<link rel="stylesheet" href="AddEvents.css">
	<link rel="stylesheet" href="CommentsBox.css">
	<link rel="stylesheet" href="Calendar.css">
	<link rel="stylesheet" href="OtherLikesBox.css">
	<link rel="stylesheet" href="BannerStyle.css">
	<title>Skejewels / Recognition</title>
</head>
<body id="Body">
<div id="Banner"></div>
<div id="BarBanner">
	<a href="NewMain.php" id="jewel">
		<img src="Jewel.png"  height="85%" border="0">
	</a>
	<input id="Search" type="text" placeholder="Search Skejewels" onkeyup="showResult(this.value)">

	<ul id="Logos">
		<li id="NotificationsLogo" onclick="location.href=NotificationsPage.php"><a id="notificationText" href="NotificationsPage.php">
			Notifications</a></li>
		<li id="RequestsLogo" onclick="location.href=RequestsPage.php"><a  id="requestText" href="RequestsPage.php">
			Friend Requests</a></li>
	</ul>

	<button type="button" id="AddButton" onclick="hideIt()">+ Add Event +</button>

	<div id="LiveSearch"></div>
</div>

<div style="position: absolute; top:60px; color: white; left: 10px;">Icon made by <a style="color:white;" href="http://www.danielbruce.se" title="Daniel Bruce">Daniel Bruce</a> from <a  style="color:white;" href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed under <a style="color:white;" href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0">CC BY 3.0</a></div></body></html></br>
<p>Coded and Designed By Josh Sparks</p></div>

</body>
</html>
