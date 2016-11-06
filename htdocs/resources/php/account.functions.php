<?php 

function loggedIn(){
	if(!isset($_SESSION['loggedIn'])){
		return False;
	}
	if(!isset($_SESSION["ipAddress"])){
		return False;
	}
	if($_SESSION["ipAddress"]!=$_SERVER["REMOTE_ADDR"]){
		return False;
	}
	
	return True;
}

function userId(){
	if(!isset($_SESSION['email'])){
		return False;
	}
	
	define('HOST','localhost');
	define('USER','userclient');
	define('PASSWORD','1234');
	define('DBTABLE','safespace');
	$db = new mysqli(HOST,USER,PASSWORD,DBTABLE);
	$email = $db -> real_escape_string($_SESSION['email']);
	$query = 'SELECT id FROM accounts WHERE email="'.$email.'"';
	$result = $db -> query($query);
	$db -> close();
	
	$rows = $result -> fetch_all(MYSQLI_ASSOC);
	if(empty($rows)){
		return False;
	}
	
	$userId = $rows[0]['id'];
	return $userId;
}

?>