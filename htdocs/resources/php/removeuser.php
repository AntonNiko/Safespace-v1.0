<?php 
include('C:\xampp\htdocs\resources\php\removeuser.functions.php');

if(!isset($_GET["id"])){
	header("Location: http://localhost/login/");
}

$userID = intval($_GET["id"]);

deleteFromDB($userID);
deleteUserFolder($userID);

