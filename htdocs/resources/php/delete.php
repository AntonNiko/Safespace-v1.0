<?php 
session_start();
include('C:\xampp\htdocs\resources\php\delete.functions.php');

if(isset($_POST["df_submit"])){
	if(!validPostVars($_POST)){
		deleteErrorSession();
	}
	
	// RETRIEVE TOKEN INDEX (ORDER IN WHICH IT IS PLACED IN FILES)
	$tokenIndex = preg_split('/_/',$_POST["df_token"])[1];
	if(!validDeleteFormToken("df".$tokenIndex)){
	    deleteErrorSession();	
	}
	
	$fileName = sanitizeInput($_POST["df_file"]);
	if(validUserFile($fileName)){
	    deleteUserFile($fileName);
	    deleteSuccessSession();
	}else{
	    deleteErrorSession();
	}	
}


