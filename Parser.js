var instance = false;	//we call this all the time to update
var state;

function Parser () {
	this.add = addToSQL;
	this.editor = editSQL;
	//this.parse = parseInformation;
}

function editSQL (id,name,startMonth, startDay, startHour, startMinute,endMonth, endDay, endHour, endMinute, Visibility) {
	name = name.replace("\'", "''");


	
	xmlhttp.onreadystatechange = function() {
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){

		}
	}
	xmlhttp.open("GET","SQLEdit.php?id="+id+"&n="+name+"&sM="+startMonth+"&sD="+startDay+"&sH="+startHour
		+"&sMi="+startMinute+"&eM="+endMonth+"&eD="+endDay+"&eH="+endHour+"&eMi="+endMinute+
		"&rT="+RepeatType+"&eRM="+EndRepeatMonth+"&eRD="+EndRepeatDay+"&v="+Visibility
		,true);
	xmlhttp.send();
	
}
function log(param){
   				setTimeout(function(){
   				    throw new Error("Debug: "+param)
   				},0)
			}

function addToSQL (name,startMonth, startDay, startHour, startMinute,endMonth, endDay, endHour, endMinute, RepeatType, EndRepeatMonth, EndRepeatDay, Visibility) {
	name = name.replace("\'", "''");
	if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

	

}

