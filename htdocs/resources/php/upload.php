<?php 
/*
* Provide file upload to to cloud server
*/
session_start();
include('C:\xampp\htdocs\resources\php\upload.functions.php');

if(isset($_POST["uf_submit"])){
	if(!validPostVars($_POST)){
		uploadErrorSession();
	}
	
    // Check Form Token Validity
	if(!validFormToken('uf')){
		uploadErrorSession();
	}
	
	if(empty($_FILES['uf_file'])){
		uploadErrorSession();
	}
	// Check $_FILES['uf_file']['error'] value.
	switch($_FILES['uf_file']['error']){
		case UPLOAD_ERR_OK:
		    break;
		case UPLOAD_ERR_NO_FILE:
		    $_SESSION["uploadError"] = true;
			header("Location: http://localhost/home/");
		    //throw new RuntimeException('No file sent.');
		case UPLOAD_ERR_INI_SIZE:
		case UPLOAD_ERR_FORM_SIZE:
		    $_SESSION["uploadError"] = true;
			header("Location: http://localhost/home/");
		    //throw new RuntimeException('Exceeded filesize limit.');
		default:
		    $_SESSION["uploadError"] = true;
			header("Location: http://localhost/home/");
		    //throw new RuntimeException('Unknown Errors.');
	}
	// Check $_FILES['uf_file'] size 
	if(!validSize($_FILES['uf_file'])){
		uploadErrorSession();
	}
	
	// Move Uploaded File to User's Personals
	uploadFileToPersonals($_FILES['uf_file']);
	uploadSuccessSession();
}