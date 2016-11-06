<?php 

function uploadErrorSession(){
	$_SESSION['uploadError'] = True;
	header('Location: http://localhost/login/');
	die();
}

function uploadSuccessSession(){
	$_SESSION['uploadSuccess'] = True;
	header('Location: http://localhost/home/');
	die();
}

function validFilenameFormat($originalName){
	// REPLACE SPACES W/ DASHES
	$finalName = str_replace(" ","-",$originalName);
	// REPLACE AMPERSAND W/ DASH
	$finalName = str_replace("&","-",$finalName);
	// REPLACE COMMAND W/ UNDERSCORE
	$finalName = str_replace(",","_",$finalName);
	return $finalName;
}

function uploadFileToPersonals($file){
	$originLocation = $file['tmp_name'];
	$fileName = validFilenameFormat($file['name']);
	
	$destinationLocation = 'C:\\xampp\\safespace-basedir\\'.$_SESSION['userId'].'\\personals\\'.$fileName;
	
	// Register Location in metadata.json 
	$metadataFile = 'C:\\xampp\\safespace-basedir\\'.$_SESSION['userId'].'\\metadata.json';
	$jsonString = file_get_contents($metadataFile);
	$data = json_decode($jsonString,true);
	
	// Append to Files array (To Personals Right Now)
	$data['files']['personals\\'.$fileName] = Array(
	    time(),
	    time()
	);
	$jsonStringNew = json_encode($data,JSON_PRETTY_PRINT);
	
	// Save Changes & Move Uploaded File 
	move_uploaded_file($originLocation,$destinationLocation);
	file_put_contents($metadataFile,$jsonStringNew);
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
	$validVars = array('uf_file','uf_token','uf_submit');
	
	foreach($postVars as $varName=>$value){
		if(!in_array($varName,$validVars)){
			return False;
		}
	}
	return True;
}

function validSize($file){
	define('MAX_FILE_SIZE',104857600);
	if($file['size']>MAX_FILE_SIZE){
		return False;
	}	
	return True;
}