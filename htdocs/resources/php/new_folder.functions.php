<?php 


function newFolder($name){
	$folderPath = 'C:\xampp\safespace-basedir\\'.$_SESSION["userId"].'\\personals\\'.$name;
	mkdir($folderPath);
	
	// Register Location in metadata.json 
	$metadataFile = 'C:\\xampp\\safespace-basedir\\'.$_SESSION['userId'].'\\metadata.json';
	$jsonString = file_get_contents($metadataFile);
	$data = json_decode($jsonString,true);
	
	// Append to Files array (To Personals Right Now)
	$data['files']['personals\\'.$name] = Array(
	    time(),
	    time(),
		"dir"
	);
	$jsonStringNew = json_encode($data,JSON_PRETTY_PRINT);
	file_put_contents($metadataFile,$jsonStringNew);
	
	header('Location: http://localhost/home');
}

function sanitizeInput($str){
	$result = htmlentities($str);
	return $result;
}

function validFolderName($name){
	if(strlen($name)<1){
		return False;
	}
	if(!preg_match('/^(\w|_)+$/',$name)){
		return False;
	}
	return True;
}

function validFormToken($form){
	if(!isset($_SESSION[$form.'_token'])){
		return False;
	}
	if(!isset($_POST[$form.'_token'])){
		return False;
	}
	if($_SESSION[$form.'_token'] != $_POST[$form.'_token']){
		return False;
	}
	return True;
}

function validPostVars($postVars){
	$validVars = array('nf_name','nf_submit');
	
	foreach($postVars as $varName=>$value){
		if(!in_array($varName,$validVars)){
			return False;
		}
	}
	return True;
}

function folderErrorSession(){
	$_SESSION["folderError"] = True;
	header("Location: http://localhost/home");
	die();
}