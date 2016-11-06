<?php 
 
function newFormToken($formName){
	$token = md5(uniqid(random_int(0,getRandMax()),true));
	$_SESSION[$formName."_token"] = $token;
	
	return $token;
}


?>