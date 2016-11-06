<?php 
include('C:\xampp\htdocs\form_sec\resources\php\comment.functions.php');

if($_SERVER['REQUEST_METHOD']!="POST"){
	requestError();
}
if(!isset($_POST['submit_comment'])){
	requestError();
}
if(!validPostValues()){
	
}








?>