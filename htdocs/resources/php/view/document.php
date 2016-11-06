<?php 
include('C:\xampp\htdocs\resources\php\filedisplay.functions.php');

function displayDocument($docPath){
	/*
	* Transfer Document to temp folder for preview. Folder must have random name 
	*/
	
	if(!validRegisteredTempFolder($docPath)){
		makeNewFolder($docPath);
	}
	if(!registeredTempFolderExists($docPath)){
		makeNewFolder($docPath);
	}	
	
	$file = returnTempPath($docPath);
	
	?>
	<embed src="http://localhost/files/<?php echo $file; ?>" width="100%" height="600px"></embed>
	<?php 
    	
}