<?php 
/*
* Script included on all website pages, provides security features and session management tools
*/
define("SESSION_TIMEOUT",30);

if(!isset($_SESSION)){
	session_start();
	$_SESSION["canary"] = time();
}

// REGENERATE SESSION ID EVERY 5 MINUTES. IF NOT SET, CREATE NEW VAR
if(!isset($_SESSION["canary"])){
	session_regenerate_id(True);
	$_SESSION["canary"] = time();
}
if($_SESSION["canary"] < time()-SESSION_TIMEOUT){
	session_regenerate_id(True);
	$_SESSION["canary"] = time();
}

function generateFormToken($form){
	$token = md5(uniqid(microtime(),true));
	$_SESSION[$form.'_token'] = $token;
	return $token;
}

function displayLoginError(){
	if(isset($_SESSION['loginError'])){
		unset($_SESSION['loginError']);
		?>
			<p style="color:#ff0000;">Login Error</p>
		<?php 
	}
}

function displaySignupError(){
	if(isset($_SESSION['signupError'])){
		unset($_SESSION['signupError']);
		?>
			<p style="color:#ff0000;">Signup Error</p>
		<?php 
	}
}

// TEMPORARY FUNCTION - Show Signup success message
function displaySignupSuccess(){
	if(isset($_SESSION['signupSuccess'])){
		unset($_SESSION['signupSuccess']);
		?>
			<p style="color:#00ff00;">Signup Success</p>
		<?php 
	}
}
?>