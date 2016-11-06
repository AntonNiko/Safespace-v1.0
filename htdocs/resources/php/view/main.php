<?php
define('IMAGE_EXTENSIONS',array('jpg','gif','tif','png'));
define('DOCUMENT_EXTENSIONS',array('pdf','docx','json'));
define('AUDIO_EXTENSIONS',array('mp3','flac','ogg','m4a'));
define('VIDEO_EXTENSIONS',array('mp4'));
define('SOURCECODE_EXTENSIONS',array('py','java','php'));
define('EXCEL_SPREADSHEET_EXTENSIONS',array('xlsx'));

function fullPath($imageName){
	$metadataStr = file_get_contents('C:\xampp\safespace-basedir\492247538\metadata.json');
	$metadata = json_decode($metadataStr,true);	
	
	foreach($metadata['files'] as $name=>$property){
		if($imageName==$name){
			$result = $metadata['homedir'].$name;
			return $result;
		}
	}
	header('Location: http://localhost/home/');
	die();
}

function in_arrayi($needle,$haystack){
	return in_array(strtolower($needle), array_map('strtolower', $haystack));
}

function refreshViewPage(){
	$_SESSION["Location"] = $_SERVER["REQUEST_URI"];
	header("Location: http://localhost/resources/php/redirect/viewRedirect.php");
}

function invalidFileType(){
	$_SESSION["invalidFileType"] = True;
	header("Location: http://localhost/home/");
	die();
}

function viewFile($file){
	$fileParts = pathinfo($file);
	$extension = $fileParts['extension'];
	if(in_arrayi($extension,IMAGE_EXTENSIONS)){
		include('C:\xampp\htdocs\resources\php\view\image.php');
		$imgPath = fullPath($file);
		displayImage($imgPath);
	}elseif(in_arrayi($extension,SOURCECODE_EXTENSIONS)){
        include('C:\xampp\htdocs\resources\php\view\code.php');
		$codePath = fullPath($file);
		displayCode($codePath);
	}elseif(in_arrayi($extension,AUDIO_EXTENSIONS)){
		include('C:\xampp\htdocs\resources\php\view\audio.php');
		$audioPath = fullPath($file);
		displayAudio($audioPath);
	}elseif(in_arrayi($extension,VIDEO_EXTENSIONS)){
		include('C:\xampp\htdocs\resources\php\view\video.php');
		$videoPath = fullPath($file);
		displayVideo($videoPath);		
	}elseif(in_arrayi($extension,DOCUMENT_EXTENSIONS)){
		include('C:\xampp\htdocs\resources\php\view\document.php');
		$docPath = fullPath($file);
		displayDocument($docPath);
	}else{
		invalidFileType();
	}
}
