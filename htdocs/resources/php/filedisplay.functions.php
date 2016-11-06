<?php 
define("FOLDER_TIMEOUT",10); // secs

function random32Hex(){
	return md5(uniqid(microtime(),true));
}

function makeHtaccess($dir,$ip){
	$data = "order deny,allow \n deny from all \n allow from $ip";
	
	$fullPath = $dir."\\.htaccess";
	$fileHandle = fopen($fullPath,"a");
	fwrite($fileHandle,$data);
	fclose($fileHandle);
}

function registeredTempFolderExists($imagePath){
	if(!file_exists('C:\xampp\htdocs\files\\'.returnTempPath($imagePath))){
		return false;
	}
	return true;
}

function validRegisteredTempFolder($imagePath){
	$imgName = pathinfo($imagePath)['basename'];
	
	if(!array_key_exists($imgName."_folder",$_SESSION)){
		return false;
	}
	if($_SESSION[$imgName."_folder"][1]<time()-FOLDER_TIMEOUT){
		return false;
	}
	return true;
}

function makeNewFolder($imagePath){
	$folderName = random32Hex();
	$tempFolder = 'C:\xampp\htdocs\files\\'.$folderName;
	mkdir($tempFolder);
	makeHtaccess($tempFolder,$_SERVER['REMOTE_ADDR']);
	
	$imgName = pathinfo($imagePath)['basename'];
	copy($imagePath,$tempFolder.'\\'.$imgName);
	
	// REGISTER TEMP FOLDER ASSOCIATED WITH IMAGE, FOR FUTURE REFERENCE
	$_SESSION[$imgName."_folder"] = array($folderName,time());
	// RETURN ARRAY OF NEW FOLDER NAME FOLLOWED BY IMAGE NAME
	return array($folderName,$imgName);
}

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
	unlink('C:\\xampp\\safespace-basedir\\'.$_SESSION['userId']."\\".$fileName);
}

function returnTempPath($imagePath){
	$imgName = pathinfo($imagePath)['basename'];
	return $_SESSION[$imgName."_folder"][0]."/".$imgName;
}