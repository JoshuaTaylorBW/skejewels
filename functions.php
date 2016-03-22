<?php 
//login check function
function loggedIn()
{

	if(isset($_SESSION['Username']) || isset($_COOKIE['cookies'])) {
		$loggedIn = TRUE;
		createVariables();
		return $loggedIn;
	}else{
		$loggedIn = FALSE;

		return $loggedIn; 
	}
}
function createVariables()
{
	if(session_status() == PHP_SESSION_NONE){
		session_start();
	}
	if(isset($_COOKIE['cookies'])){
		$_SESSION['UserId'] =
			 $_COOKIE["cookies"]['UserId'];
		$_SESSION['Nickname'] =
			 $_COOKIE["cookies"]['Nickname'];
		$_SESSION['FirstNames'] =
			 $_COOKIE["cookies"]['FirstNames'];
		$_SESSION['LastNames'] =
			 $_COOKIE["cookies"]['LastNames'];
		$_SESSION['Friends']=(string)$_COOKIE["cookies"]['Friends'];
	}	
}

 ?>