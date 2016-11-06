<?php 

function endUserSession(){
	if(!isset($_SESSION['loggedIn'])){
		return False;
	}
	session_destroy();
}
?>