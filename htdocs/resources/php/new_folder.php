<?php 
session_start();
include('C:\xampp\htdocs\resources\php\new_folder.functions.php');

if(isset($_POST["nf_submit"])){
	if(!validPostVars($_POST)){
		folderErrorSession();
	}
	
	$folderName = sanitizeInput($_POST["nf_name"]);
	if(validFolderName($folderName)){
		newFolder($folderName);
	}else{
		folderErrorSession();
	}	
}