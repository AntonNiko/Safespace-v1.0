<?php 
define("FOLDER_TIMEOUT",10); // Seconds
include('C:\xampp\htdocs\resources\php\filedisplay.functions.php');

function validPostVars($postVars){
	$validVars = array("dl_file","dl_token","dl_submit");
	foreach($postVars as $varName=>$value){
		if(!in_array($varName,$validVars)){
			return False;
		}
	}
	return True;
}

function downloadFile($fileName){
	ob_end_clean();
	$fullPath = 'C:\xampp\safespace-basedir\\'.
			$_SESSION['userId'].'\\'.$fileName;
			
	if(!validRegisteredTempFolder($fullPath)){
		makeNewFolder($fullPath);
	}
	if(!registeredTempFolderExists($fullPath)){
		makeNewFolder($fullPath);
	}
	
	// ACTUALLY DOWNLOAD THE FILE ITSELF
	$fileURL = 'http://localhost/files/'.returnTempPath($fullPath);
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"" . basename($fileURL) . "\""); 
	readfile($fileURL);
	
	header("Location: http://localhost/home");
	die();
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

function validDownloadFormToken($form){
	if(!isset($_SESSION[$form.'_token'])){
		return False;
	}
	if(!isset($_POST['dl_token'])){
		return False;
	}
	if($_SESSION[$form.'_token'] != preg_split('/_/',$_POST['dl_token'])[0]){
		return False;
	}
	return True;
}

function downloadErrorSession(){
    $_SESSION["downlaodError"] = true;
	header("Location: http://localhost/home");
	die();
}

function sanitizeInput($str){
	$result = htmlentities($str);
	return $result;
}