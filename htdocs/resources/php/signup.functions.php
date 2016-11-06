<?php 


function metadataStruct($userID){
	$jsonStruct = array(
	    "homedir"=>"C:\\xampp\\safespace-basedir\\".$userID,
		"files"=> new ArrayObject()
		);
	return $jsonStruct;
}

function sanitizeInput($str){
	$result = htmlspecialchars($str);
	return $result;
}

function verifyFormToken($form){
	if(!isset($_SESSION[$form."_token"])){
		return False;
	}
	if(!isset($_POST['token'])){
		return False;
	}
	if($_SESSION[$form."_token"] != $_POST['token']){
		return False;
	}
	
	return True;
}

function validEmail($email){
	if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
		return False;
	}
	return True;
}

function validName($name){
	if(!preg_match('/^[a-zA-Z][a-zA-Z\s]+$/',$name)){
		return False;
	}
	return True;
}

function validPassword($password,$passwordConfirm){
	if(strlen($password)<6){
		return False;
	}
	if($password != $passwordConfirm){
		return False;
	}
	return True;
}

function encryptPassword($password){
	$result = password_hash($password,PASSWORD_DEFAULT);
	return $result;
}

function generateUserID(){
	$stringID = "";
	for($i=0; $i<9; $i++){
		$stringID = $stringID.((string) random_int(0,9));
	}
	return $stringID;
}

function addUser($email,$firstName,$lastName,$password){
	define('HOST','localhost');
	define('USER','userclient');
	define('PASSWORD','1234');
	define('DBTABLE','safespace');
	
	$db = new mysqli(HOST,USER,PASSWORD,DBTABLE);
	
	$salt = encryptPassword($password);
	$stringID = generateUserID();
	
	$email = $db -> real_escape_string($email);
	$firstName = $db -> real_escape_string($firstName);
	$lastName = $db -> real_escape_string($lastName);
	$salt = $db -> real_escape_string($salt);
	$stringID = $db -> real_escape_string($stringID);
	$query = 'INSERT INTO accounts(id,email,firstname,lastname,salt)
		      VALUES('.$stringID.',"'.$email.'","'.$firstName.'","'.$lastName.'","'.$salt.'")
			 ';
	$db -> query($query) or die($db -> error);
	$db -> close();
	
	// Calling Function within script
	addUserFolder($email);
}
	
function addUserFolder($email){
	/*
	* Takes email since folder name based on DB stored value
	* E.g.: generateUserID()->003890233 In DB: 3890233 So folder name must be 3890233
	*/
	
	define('HOST','localhost');
	define('USER','userclient');
	define('PASSWORD','1234');
	define('DBTABLE','safespace');
	$db = new mysqli(HOST,USER,PASSWORD,DBTABLE);
	
	$email = $db -> real_escape_string($email);
	$query = 'SELECT id FROM accounts WHERE email="'.$email.'"';
	$result = $db -> query($query);
	$db -> close();
	
	$rows = $result -> fetch_all(MYSQLI_ASSOC);
	if(empty($rows)){
		die('<b>Invalid Email</b> - Provide valid email to add user folder');
	}
	$userID = strval($rows[0]['id']);
	
	// Create new folder 
	mkdir('C:\xampp\safespace-basedir\\'.$userID);
	// Create Log,Metadata,Personals,Shared Files & Folders
	$logFile = fopen('C:\xampp\safespace-basedir\\'.$userID.'\log.txt','w');
	fclose($logFile);
	
	// CREATE & POPULATE METADATA.JSON W/ STRUCTURE
	$metaFile = fopen('C:\xampp\safespace-basedir\\'.$userID.'\metadata.json','w');
	fclose($metaFile);
	file_put_contents('C:\xampp\safespace-basedir\\'.$userID.'\metadata.json',json_encode(metadataStruct($userID),JSON_PRETTY_PRINT));
	
	mkdir('C:\xampp\safespace-basedir\\'.$userID.'\personals');
	mkdir('C:\xampp\safespace-basedir\\'.$userID.'\shared');

}

function signupSuccessSession(){
	// TODO: SET SESSION & REDIRECT TO USER PAGE
	// Temporary Solution - Redirect to home page
	$_SESSION['signupSuccess'] = True;
	header('Location: http://localhost');
	die();
}

function signupErrorSession(){
	$_SESSION['signupError'] = True;
	header('Location: http://localhost/login/');
	die();
}










?>