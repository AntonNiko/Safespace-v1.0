<?php 
include('C:\xampp\htdocs\resources\php\filedisplay.functions.php');

function displayAudio($audioPath){
	
    if(!validRegisteredTempFolder($audioPath)){
		makeNewFolder($audioPath);
	}
	if(!registeredTempFolderExists($audioPath)){
		makeNewFolder($audioPath);
	}
	
	?>
	<audio class="audio-file" autoplay controls>
	    <source src="http://localhost/files/<?php echo returnTempPath($audioPath); ?>">
	</audio>
	<?php 
}