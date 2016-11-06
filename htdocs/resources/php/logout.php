<?php 
session_start();
include('C:\xampp\htdocs\resources\php\logout.functions.php');

if(isset($_POST['lof_submit'])){
	endUserSession();
	header('Location: http://localhost/');
	die();
}








?>