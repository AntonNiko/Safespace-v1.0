<?php 
include('C:\xampp\htdocs\resources\php\filedisplay.functions.php');

function displayVideo($videoPath){
	
    if(!validRegisteredTempFolder($videoPath)){
		makeNewFolder($videoPath);
	}
	if(!registeredTempFolderExists($videoPath)){
		makeNewFolder($videoPath);
	}
	
	?>
	<video class="vide-file" autoplay controls>
	    <source src="http://localhost/files/<?php echo returnTempPath($videoPath); ?>" type="video/mp4">
	</video>
	<?php 
}