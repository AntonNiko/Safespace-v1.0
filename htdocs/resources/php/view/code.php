<?php 
include('C:\xampp\htdocs\resources\php\filedisplay.functions.php');

function displayCode($codePath){
	
	if(!validRegisteredTempFolder($codePath)){
		makeNewFolder($codePath);
	}
	if(!registeredTempFolderExists($codePath)){
		makeNewFolder($codePath);
	}
	
	$fullPath = 'http://localhost/files/'.returnTempPath($codePath);
	$fileArray = file($fullPath);
	?>
	<code class="code-viewer">
	<?php 
	foreach($fileArray as $line){
		echo $line."<br>";
	}
	?>
	</code>
	<?php 
}