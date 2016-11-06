<?php 

function requestError(){
	$_SESSION["request_error"] = True;
	header('Location: http://localhost/form-sec/');
	die();
}

function sanitizeInput($data){
	$data = mb_convert_encoding($data,'UTF-8','UTF-8');
	$result = htmlspecialchars(htmlentities($data));
	return $result;
}

function validToken($token,$formName){
	if(!isset($_SESSION[$formName."_token"])){
		return False;
	}
	if($token!=$_SESSION[$formName."_token"]){
		return False;
	}
	return True;
}

function validPostValues(){
	
}





?>