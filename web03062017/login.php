<?php 
session_start();
include "../inc/dbinfo.inc";
if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
}
$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
?>
<!DOCTYPE html>
<html>
<head>
	
	<meta charset="UTF-8">
	<title>Login</title>
	<meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>
</head>

<body>
<?php
include "header.php";
?>
<?php
	if($_SESSION["loggedin"]==0){
		if(isset($_POST['submit'])){
			$username=$_POST["username"];
			$password=$_POST["password"];
			$result = $connection->query("SELECT * FROM users WHERE username='$username' OR email='$username' AND PASSWORD='$password';");
			if($result){
				if (mysqli_num_rows($result)>0){
					$linha=mysqli_fetch_assoc($result);
					$_SESSION["username"]=$username;
					$_SESSION["id"]=$linha['id'];
					//$_SESSION["picture"]=$linha["picture"];
					$_SESSION["email"]=$linha["email"];
					//$_SESSION["bio"]=$linha["bio"];
					$_SESSION["is_artist"]=$linha["is_artist"];
					$_SESSION["loggedin"]=1;
					$_SESSION["admin"]=0;

					header('Location: home.php');
				}
				else{
					echo "Username/email does not exist.";
				}
			}
			else{
				echo "Could not establish connection.";
			}
		}
	}
	else{
		echo "Valid session already active.";
	}
?>

<div class="container">
	<form action="login.php" method="post">
		<div class="row">
        	<div class=".col-xs-6 .col-lg-12 col-sx-offset-1">
                <h1>Login</h1>
			<div class="form-group float-label-control">
				<label>
					<span>Username/email</span>
					<input class="form-control" type="text" name="username" required>
				</label>
			</div>
			<div class=".col-xs-6 .col-lg-12 col-sx-offset-1">
				<label>
					<span>Password</span>
					<input class="form-control" type="password" name="password" required>
	
				</label>
			</div>
			<div class=".col-xs-6 .col-lg-12 col-sx-offset-1">
				<button type="submit" name='submit'>Login</button>
			</div>
				If you don't have an account<a href="register.php" class="form-log-in-with-existing">Sign Up here</a>
			</div>
		</div>
	</form>
</div>
<?php $connection->close();?>

</body>
</html>
