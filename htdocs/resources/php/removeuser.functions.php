<?php 


function deleteFromDB($userID){
	define('HOST','localhost');
	define('USER','root');
	define('PASSWORD','Mess-Iahfor +,iS27Great Grates==');
	define('DBTABLE','safespace');
	
	$db = new mysqli(HOST,USER,PASSWORD,DBTABLE);
	
	
	$userID = $db->real_escape_string($userID);

	$query = 'DELETE FROM accounts WHERE id='.$userID;
	$db -> query($query) or die($db->error);
	$db -> close();
}

function deleteUserFolder($userID){
	$baseDir = 'C:\xampp\safespace-basedir\\'.$userID;

	// UNLINK FILES AND FOLDERS IN USER FOLDER
	// PERSONALS 
	$dirHandle = opendir($baseDir."\\personals");
	while($file = readdir($dirHandle)){
		if($file!="." && $file!=".."){
			/*
			* Assumes no sub-directories present
			*/
			unlink($dirHandle."\\".$file); 
		}
	}
	closedir($dirHandle);
	// DELETE SHARED,PERSONALS FOLDER 
	rmdir($baseDir."\\personals");
	rmdir($baseDir."\\shared");
	// DELETE METADATA,LOG 
	unlink($baseDir."\\metadata.json");
	unlink($baseDir."\\log.txt");
	// DELETE FOLDER
	rmdir($baseDir);
}