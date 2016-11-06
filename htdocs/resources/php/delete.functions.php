<?php 

function deleteUserFile($fileName){
    // DELETE FILE FROM METADATA JSON
    $metadataFile = 'C:\\xampp\\safespace-basedir\\'.$_SESSION['userId'].'\\metadata.json';
 	$metadataStr = file_get_contents($metadataFile);
	$metadata = json_decode($metadataStr,true);   
	unset($metadata['files'][$fileName]);
	
	$jsonStringNew = json_encode($metadata,JSON_PRETTY_PRINT);
	// Save Changes & Move Uploaded File 
	file_put_contents($metadataFile,$jsonStringNew);
    
	
	// DELETE ACTUAL FILE FROM DIRECTORY
	$path = 'C:\\xampp\\safespace-basedir\\'.$_SESSION['userId']."\\".$fileName;
	unlink($path) or rmdir($path);
}

function validPostVars($postVars){
	$validVars = array("df_file","df_token","df_submit");
	foreach($postVars as $varName=>$value){
		if(!in_array($varName,$validVars)){
			return False;
		}
	}
	return True;
}

function validUserFile($fileName){
	$metadataStr = file_get_contents('C:\xampp\safespace-basedir\\'.
			$_SESSION['userId'].'\metadata.json');
	$metadata = json_decode($metadataStr,true);
	$files = $metadata['files'];
	
	if(array_key_exists($fileName,$files)){
	    return True;	
	}else{
	    return False;
	}
}

function validDeleteFormToken($form){
	if(!isset($_SESSION[$form.'_token'])){
		return False;
	}
	if(!isset($_POST['df_token'])){
		return False;
	}
	if($_SESSION[$form.'_token'] != preg_split('/_/',$_POST['df_token'])[0]){
		return False;
	}
	return True;
}

function deleteErrorSession(){
    $_SESSION["deleteError"] = true;
	header("Location: http://localhost/home");
	die();
}

function deleteSuccessSession(){
    $_SESSION["deleteSuccess"] = true;
	header("Location: http://localhost/home");
	die();
}

function sanitizeInput($str){
	$result = htmlentities($str);
	return $result;
}