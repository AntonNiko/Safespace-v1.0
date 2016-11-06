<?php 
/*
* Script Included where user must be logged in to view.
*/
include('C:\xampp\htdocs\resources\php\account.functions.php');

if(!loggedIn()){
	header('Location: http://localhost/');
	die();
}
$_SESSION['userId'] = userId();

?>