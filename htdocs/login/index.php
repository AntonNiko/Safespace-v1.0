<?php 
	session_start();
	include('C:\xampp\htdocs\resources\php\site.php');
	$loginFormToken = generateFormToken('lf');
	$signupFormToken = generateFormToken('sf');

	if(isset($_SESSION['loggedIn'])){
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
	<title>Safespace - Login</title>
	
	<script type="text/javascript" src="http://localhost/resources/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://localhost/resources/js/jquery-3.0.0.js"></script>
	<script type="text/javascript">
	    function validEmail(email){
			var emailRe = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if(!emailRe.test(email)){
				return false;
			}			
			return true;
		}
	
	    function validPassword(password){
			var passwordRe = /^(\w|\s){4,50}$/;
			if(!passwordRe.test(password)){
				return false;
			}
			return true;
		}
	
	    function lf_validate(){
			var email = document.loginform.lf_email.value;
			var password = document.loginform.lf_password.value;
			
			// Valid Email format 
			if(!validEmail(email)){
				return false;
			}
			
			// Valid Password format
			if(!validPassword(password)){
				return false;
			}

			return true;
		}
		
		$(document).ready(function(){
			
		});
	</script>
	<link rel="stylesheet" href="http://localhost/resources/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<form name="loginform" onsubmit="return lf_validate();" action="http://localhost/resources/php/login.php" method="POST">
				<?php 
					displayLoginError();
				?>
				<div class="form-group">
					<label for="lf_email">Email:</label>
					<input type="text" name="lf_email" class="form-control" value="ant.nikitenko@gmail.com">
				</div>
				<div class="form-group">
				    <label for="lf_password">Password:</label>
					<input type="password" name="lf_password" class="form-control" id="lf_password" value="123456">
				</div>
				<input type="hidden" name="lf_token" id="lf_token" value="<?php echo $loginFormToken; ?>">
				<input type="submit" name="lf_submit" class="btn btn-default" id="lf_submit" value="Login">
			</form>
		</div>
	</div>
	<hr>
	<div class="row">
	    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<form name="signupform" action="http://localhost/resources/php/signup.php" method="POST">
				<?php 
					displaySignupError();
					displaySignupSuccess();
				?>
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="text" name="email" class="form-control" value="ant.nikitenko@gmail.com">
				</div>
				<div class="form-group">
					<label for="firstName">First Name:</label>
					<input type="text" name="firstName" class="form-control">
				</div>			
				<div class="form-group">
					<label for="lastName">Last Name:</label>
					<input type="text" name="lastName" class="form-control">
				</div>					
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" name="password" class="form-control">
				</div>	
				<div class="form-group">
					<label for="passwordConfirm">Confirm Password:</label>
					<input type="password" name="passwordConfirm" class="form-control">
				</div>	
				<input type="hidden" name="token" value="<?php echo $signupFormToken; ?>">
				<input type="submit" class="btn btn-default" name="signupSubmit" value="Sign up">
			</form>
		</div>
	</div>
<div class="container">
</body>
</html>
