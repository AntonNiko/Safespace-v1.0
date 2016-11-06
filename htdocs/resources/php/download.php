<?php 
session_start();
include('C:\xampp\htdocs\resources\php\download.functions.php');

if(isset($_POST["dl_submit"])){
	if(!validPostVars($_POST)){
		downloadErrorSession();
	}

	// RETRIEVE TOKEN INDEX (ORDER IN WHICH IT IS PLACED IN FILES)
	$tokenIndex = preg_split('/_/',$_POST["dl_token"])[1];
	if(!validDownloadFormToken("dl".$tokenIndex)){
	    downloadErrorSession();
	}
	
	$fileName = sanitizeInput($_POST["dl_file"]);
	if(validUserFile($fileName)){
		downloadFile($fileName);
	}else{
	    downloadErrorSession();
	}		
	
}