<?php 
session_start();
session_destroy();

setcookie("cookies[UserId]", "", time()-31536000);
setcookie("cookies[Nickname]", "", time()-31536000);
setcookie("cookies[FirstNames]", "", time()-31536000);
setcookie("cookies[LastNames]", "", time()-31536000);
setcookie("cookies[Friends]", "", time()-31536000);

header('Location: index.php');
 ?>