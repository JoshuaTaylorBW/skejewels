function Schedule() {
	this.makeTable = makeOrgTable;
}

//this method organizes and makes a table through
//MonthOrganize.php
function makeOrgTable (element, month) {
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			 document.getElementById(element).innerHTML = xmlhttp.responseText;
		}
	}

	xmlhttp.open("GET","MonthOrganize.php?m="+month, true);
	xmlhttp.send();

}