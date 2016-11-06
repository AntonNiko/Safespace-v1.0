<?php 

function readableTimestamp($time){
	date_default_timezone_set("America/Vancouver");
	$formattedTime = date("d F o - H:i:s",$time);
	return $formattedTime;
}

function itemSize($file,$denomination="MB"){
	$KB_1 = 1024;
	$MB_1 = 1048576;
	$GB_1 = 1073741824;
	
	$userID = $_SESSION["userId"];
    $fileSize = filesize('C:\\xampp\\safespace-basedir\\'.$userID.'\\'.$file);

	if($fileSize>$GB_1){
		$fileSize/=(1024*1024*1024);
		$fileSize = round($fileSize,2)." GB";
	}elseif($fileSize>$MB_1){
		$fileSize/=(1024*1024);
		$fileSize = round($fileSize,2)." MB";
	}elseif($fileSize>$KB_1){
		$fileSize/=(1024);
		$fileSize = round($fileSize,2)." KB";
	}else{
		$fileSize = round($fileSize,2)." B";
	}
	return $fileSize;
}

function outputFiles($jsonObj){
	$files = $jsonObj['files'];
	?>
		<table class="table table-bordered" id="table-files">
		<tr>
		    <th>Filename</th>
			<th>Size</th>
			<th>Created</th>
			<th>Last Modified</th>
			<th>Action</th>
		</tr>
	<?php 
	$i = 1; // FOR SESSION VAR INDEX FOR DELETE FORMS
	foreach($files as $file=>$property){
		// STORE CSRF FIELD IN SESSION VARS FOR HOWEVER MANY FILES
		$deleteFormToken = generateFormToken("df".$i);
		$downloadFormToken = generateFormToken("dl".$i);
		
		?>
		    <tr>
			    <td>
					<?php   
					if(isset($property[2])){
						if($property[2]=="dir"){
							?><span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span><?php
						}	
					}else{
						?><span class="glyphicon glyphicon-file" aria-hidden="true"></span><?php
					}
					?>
				    
					<a href="http://localhost/view/?f=<?php echo $file; ?>">
					<?php echo preg_replace('/personals\\\\/',"",$file); ?>
					</a>
				</td>
				<td>
				<?php 
				    if(!isset($property[2])){
						echo itemSize($file); 
					}
				?>
				</td>
			    <td><?php echo readableTimestamp($property[0]);?></td>
				<td><?php echo readableTimestamp($property[1]);?></td>
				<td>
				    <form action="http://localhost/resources/php/download.php" method="POST">
						<input type="hidden" name="dl_file" value="<?php echo $file;?>">
						<input type="hidden" name="dl_token" value=<?php echo $downloadFormToken."_".$i;?>>
					    <input type="submit" class="btn btn-sm btn-default" name="dl_submit" value="Download">
					</form>
				    <form action="http://localhost/resources/php/delete.php" method="POST">
				        <input type="hidden" name="df_file" value="<?php echo $file;?>">
				        <input type="hidden" name="df_token" value="<?php echo $deleteFormToken."_".$i;?>">
				        <input type="submit" class="btn btn-sm btn-default" name="df_submit" value="Delete">
				    </form>
				</td>
			</tr>
		<?php 	
		$i++; 
	}
	?>
		</table>
	<?php 
}

function displayMetadata(){
	if(!isset($_SESSION['userId'])){
		?>
			<p>Missing Session Var: userId</p>
		<?php 	
	}else{
		$metadataStr = file_get_contents('C:\xampp\safespace-basedir\\'.
			$_SESSION['userId'].'\metadata.json');
		$metadata = json_decode($metadataStr,true);
		outputFiles($metadata);
	}
}