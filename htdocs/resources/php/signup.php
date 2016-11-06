<?php 
session_start();
include('signup.functions.php');
include('C:\xampp\safespace-basedir\passwordlock\password_lock-master\src\PasswordLock.php');

if(isset($_POST['signupSubmit'])){
	$email = sanitizeInput($_POST['email']);
	$firstName = sanitizeInput($_POST['firstName']);
	$lastName = sanitizeInput($_POST['lastName']);
	$password = sanitizeInput($_POST['password']);
	$passwordConfirm = sanitizeInput($_POST['passwordConfirm']);
	
	// Check Form Token Validity
	if(!verifyFormToken('sf')){
		signupErrorSession();
	}
	
	if(!validEmail($email)){
		signupErrorSession();
	}
	if(!validName($firstName)){
		signupErrorSession();
	}
	if(!validName($lastName)){
		signupErrorSession();
	}
	if(!validPassword($password,$passwordConfirm)){
		signupErrorSession();
	}

	addUser($email,$firstName,$lastName,$password);
	signupSuccessSession();
	
	header('Location: http://localhost');
}





?>