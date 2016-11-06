<?php 
/*
* In php\view folder, all scripts that are not main.php are functions
*/
include('C:\xampp\htdocs\resources\php\filedisplay.functions.php');

function displayImage($imagePath){
	/*
	* Display the Image to the user, by means of generating a random folder.	
	*/
	
	if(!validRegisteredTempFolder($imagePath)){
		makeNewFolder($imagePath);
	}
	if(!registeredTempFolderExists($imagePath)){
		makeNewFolder($imagePath);
	}
	
	// Show File to User
	?>
	    <img class="image-file" src="http://localhost/files/<?php echo returnTempPath($imagePath); ?>">
	<?php 
}
