<?php 
session_start();
include('C:\xampp\htdocs\resources\php\site.php');
include('C:\xampp\htdocs\resources\php\account.php');
$uploadFormToken = generateFormToken('uf');

/* ASSUMES DISPLAY.PHP INCLUDED SUCCESSFULLY
*  -> Uses Cookies to transfer data to JS 
*/
//$newFolderFormToken = generateFormToken('nf');
//setcookie('newfolder_token',$newFolderFormToken,time()+3600);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Safespace - Home</title>
	
	<link rel="stylesheet" href="http://localhost/resources/css/bootstrap.min.css">
    <style>
	input[type="file"]{
		width:200px;
		height:50px;
	}
	
	#uf_file {
		width:0.1px;
		height:0.1p
		overflow:hidden;x;
		opacity:0;
		position:absolute;
		z-index:1;
	}
	</style>
	
</head>
<body>
    <div class="container">
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="http://localhost/home">Safespace</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav">
			  <!-- Float Center Links -->
			 </ul>
		  <ul class="nav navbar-nav navbar-right">
			<li>
			<!-- Float Right Links -->
			</li>
		  </ul>
		</div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>
		
	    <div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="filedisplay">
				<?php 
					include('C:\xampp\htdocs\resources\php\display.php');
				?>		
				<button class="btn btn-default" name="nf_submit" onclick="newFolderAction()">New Folder</button>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="uploaddisplay">
				<?php 
					if(isset($_SESSION['uploadError'])){
						unset($_SESSION['uploadError']);
						?>
						<p>Upload Error</p>
						<?php
					}
					if(isset($_SESSION['uploadSucess'])){
						unset($_SESSION['uploadSucess']);
						?>
						<p>Upload Success</p>
						<?php 
					} 
					if(isset($_SESSION["deleteError"])){
						unset($_SESSION["deleteError"]);
						?>
						<p>Delete Error</p>
						<?php 
					} 
					if(isset($_SESSION["deleteSuccess"])){
						 unset($_SESSION["deleteSuccess"]);
						 ?>
						 <p>Delete Success</p>
						 <?php 
					}
					if(isset($_SESION["downloadError"])){
						unset($_SESSION["downloadError"]);
						?>
						<p>Download Error</p>
						<?php 
					}
					if(isset($_SESSION["invalidFileType"])){
						unset($_SESSION["invalidFileType"]);
						?>
						<p>File could not be opened in Browser. Download to view instead</p>
						<?php 
					}
					if(isset($_SESSION["folderError"])){
						unset($_SESSION["folderError"]);
						?>
						<p>Folder Creation Error</p>
						<?php 
					}
				?>
				<form name="uploadform" action="http://localhost/resources/php/upload.php" method="POST" enctype="multipart/form-data" onsubmit="return handleSelectedFiles()">
					<input type="file" name="uf_file" id="uf_file">
					<label class="btn btn-primary" for="uf_file">Choose A File</label>
					<input type="hidden" name="uf_token" id="uf_token" value="<?php echo $uploadFormToken; ?>">
					<input type="submit" name="uf_submit" value="Upload">
				</form>
			</div>
		</div>
		<hr>
		<div id="logout">
			<form name="logoutform" action="http://localhost/resources/php/logout.php" method="POST">
				<input class="btn btn-danger" type="submit" name="lof_submit" value="Logout">
			</form>
		</div>
	</div>
	<script type="text/javascript" src="http://localhost/resources/js/jquery-3.0.0.js" async></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" async></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" async></script>
	<script type="text/javascript">
	    function handleSelectedFiles(){
			// IF FILE IS NOT SELECTED, RETURN FALSE 
			if(typeof document.getElementById("uf_file").files[0] === "undefined"){
				return false;
			}
			
			var file = document.getElementById("uf_file").files[0];
			// IF FILE EXCEEDS MAXIMUM FILE SIZE RESTRICTION, RETURN FALSE
			const MAX_FILE_SIZE = 104857600;
			if(file.size>MAX_FILE_SIZE){
				return false;
			}
			return true;
		}
		
		var folderInputCreate = false;
		function newFolderAction(){
			var tableFiles = document.getElementById("table-files");
			
			if(folderInputCreate){
				return;
			}
			var newRow = tableFiles.insertRow(tableFiles.rows.length);
			var cell = newRow.insertCell(0);
			/*
			* Form Creation 
			*/
			// Form Node 
			var form = document.createElement("form");
			form.id = "newFolderForm";
			form.setAttribute("action","http://localhost/resources/php/new_folder.php");
			form.setAttribute("method","POST");
			form.setAttribute("onsubmit","return validFolderName()");
			cell.appendChild(form);
			
			// Form-group Node 
			var inputGroup = document.createElement("div");
			var form = document.getElementById("newFolderForm");
			inputGroup.className = "form-group";
			inputGroup.id = "folderInputGroup";
			form.appendChild(inputGroup);
			
			// Input Field
			var input = document.createElement("input");
			var inputGroup = document.getElementById("folderInputGroup");
			input.type = "text";
			input.className = "form-control";
			input.name = "nf_name";
			input.id = "nf_name";
			inputGroup.appendChild(input);
			
			// Submit Field 
			var submit = document.createElement("input");
			var form = document.getElementById("newFolderForm");
			submit.type = "submit";
			submit.className = "btn btn-default";
			submit.value = "Create Folder";
			submit.name = "nf_submit";
			form.appendChild(submit);
			
			folderInputCreate = true;
		}
		
		function validFolderName(){
			var name = document.getElementById("nf_name");
			
			var pattern = /^\w+$/;
			if(!pattern.match(name)){
				alert();
				return false;
			}else{
				alert();
				return true;
			}
		}
	</script>
</body>
</html>