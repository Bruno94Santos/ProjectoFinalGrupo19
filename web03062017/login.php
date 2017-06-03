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
	<link rel="stylesheet" href="css/form.css">

</head>
<body>
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


	<form class="form" action="login.php" method="post">
		<div class="form-register-login">
                	<div class="form-white-background">
				<div class="form-title-row">
                        		<h1>Login</h1>
                    		</div>
				<div class="form-row">
					<label>
						<span>Username/email</span>
						<input type="text" name="username" required>
					</label>
				</div>
				<div class="form-row">
					<label>
						<span>Password</span>
						<input type="password" name="password" required>
		
					</label>
				</div>
				<div class="form-row">
					<button type="submit" name='submit'>Login</button>
				</div>
				If you don't have an account<a href="register.php" class="form-log-in-with-existing">Sign Up here</a>
			</div>
		</div>
	</form>
	

<?php $connection->close();?>

</body>
</html>