<?php 
session_start();
include('C:\xampp\htdocs\resources\php\site.php');
include('C:\xampp\htdocs\resources\php\account.php');

// Redirect to home account page if no valid $_GET['f'] provided
if(!isset($_GET['f'])){
	header('Location: http://localhost/home/');
	die();	
}
if(empty($_GET['f'])){
	header('Location: http://localhost/home/');
	die();
}
if(!preg_match('/^(personals|shared)'.preg_quote('\\').'/',$_GET['f'])){
	header('Location: http://localhost/home/');
	die();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $_GET['f']; ?></title>
	
	<script type="text/javascript" src="http://localhost/resources/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://localhost/resources/js/jquery-3.0.0.js"></script>
	<script type="text/javascript" src="http://localhost/resource/js/code.viewer.js"></script>
    <link rel="stylesheet" href="http://localhost/resources/css/bootstrap.min.css">
	<link rel="stylesheet" href="http://localhost/resources/css/code.viewer.css">
	
	<style type="text/css">
	    .image-file {
			width:100%;
		}
		.audio-file {
			width:100%;
		}
		.video-file {
			width:100%;
		}
	</style>
</head>
<body>
    <div class="container">
	<div class="row">
	    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<?php 
				include('C:\xampp\htdocs\resources\php\view\main.php');
				viewFile($_GET['f']);
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<form name="back_button" action="http://localhost/resources/php/redirect/redirect_home.php" method="POST">
				<input type="submit" value="Back">
			</form>
		</div>
	</div>
	</div>
</body>
</html>