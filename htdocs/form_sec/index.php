<?php 
session_start();
include('C:\xampp\htdocs\form_sec\resources\php\formToken.php');

$commentFormToken = newFormToken("commentform");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<title>Comment Page</title>
	<style type="text/css">
	input {
		display:block;
		margin:3px;
	}
	</style>
    <script type="text/javascript">
	
	</script>
</head>
<body>
    <div id="comments">
	</div>
	<div id="commentInput">
		<?php 
		if(isset($_SESSION["request_error"])){
			unset($_SESSSION["request_error"]);
			?>
			<p>Request Error</p>
			<?php 
		}
		?>
	    <form name="commentform" action="http://localhost/form_sec/resources/php/comment.php" method="POST">
			<input type="text" name="comment_fname" placeholder="First name">
			<input type="text" name="comment_lname" placeholder="Last name">
			<input type="text" name="comment_email" placeholder="Email">
			<input type="text" name="comment_subject" placeholder="Subject">
			<textarea name="comment_message" cols=30 rows=8></textarea>
		
			<input type="hidden" name="token" value="<?php echo $commentFormToken; ?>">
		    <input type="submit" name="submit_comment">
		</form>
	</div>
</body>
</html>