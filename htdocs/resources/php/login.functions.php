<?php 

function hashPassword($password){
	$hash = password_hash($password,PASSWORD_DEFAULT);
	return $hash;
}

function validPassword($email,$password){
	define('HOST','localhost');
	define('USER','userclient');
	define('PASSWORD','1234');
	define('DBTABLE','safespace');
	
	$db = new mysqli(HOST,USER,PASSWORD,DBTABLE);
	$email = $db->real_escape_string($email);
	$query = 'SELECT * FROM accounts WHERE email="'.$email.'"';
	$queryResult = $db -> query($query) or die($db->error);
	$db -> close();

	$rows = $queryResult-> fetch_all(MYSQLI_ASSOC);
	if(empty($rows)){
		return False;
	}
	$salt = $rows[0]['salt'];
	
	$valid = password_verify($password,$salt);
	return $valid;
}

function validEmailFormat($email){
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		return False;
	}
	return True;
}

function validPasswordFormat($password){
	$rePattern = "/(\w|\s){4,50}/";
	if(!preg_match($rePattern,$password)){
		return False;
	}
	return True;
}

function startUserSession($email){
	$_SESSION['loggedIn'] = True;
	$_SESSION['email'] = $email;
	
	// CREATE NEW SESSION_ID FOR ELEVATED PRIVILEGES
	session_regenerate_id(True);
	$_SESSION["canary"] = time();
	// REGISTER CURRENT IP, TO PROTECT AGAINST SESSION FIXATION
	$_SESSION["ipAddress"] = $_SERVER["REMOTE_ADDR"];
	
	// Redirect to Main Account Page
	header('Location: http://localhost/home/');
	die();
}

function loginErrorSession(){
	$_SESSION['loginError'] = True;
	header('Location: http://localhost/login/');
	die();
}

function sanitizeInput($str){
	$result = htmlentities($str);
	return $result;
}

function validFormToken($form){
	if(!isset($_SESSION[$form.'_token'])){
		return False;
	}
	if(!isset($_POST[$form.'_token'])){
		return False;
	}
	if($_SESSION[$form.'_token'] != $_POST[$form.'_token']){
		return False;
	}
	return True;
}

function validPostVars($postVars){
	$validVars = array('lf_email','lf_password','lf_token','lf_submit');
	
	foreach($postVars as $varName=>$value){
		if(!in_array($varName,$validVars)){
			return False;
		}
	}
	return True;
}

?> 