<?php 
session_start();
include('login.functions.php');

if(isset($_POST["lf_submit"])){
	if(!validPostVars($_POST)){
		loginErrorSession();
	}
	
	$email = sanitizeInput($_POST['lf_email']);
	$password = sanitizeInput($_POST['lf_password']);
	$hash = hashPassword($password);
	
	// Validate Email & Password Format 
    if(!validEmailFormat($email) || !validPasswordFormat($password)){
		loginErrorSession();
	}
	
	// Check Form Token Validity
	if(!validFormToken('lf')){
		loginErrorSession();
	}
	
	if(validPassword($email,$password)){
		startUserSession($email);
	}else{
		loginErrorSession();
	}
}

?>