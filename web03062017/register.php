<?php 
session_start();
include "../inc/dbinfo.inc";
if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
}
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Register</title>
	<link rel="stylesheet" href="css/form.css">
</head>

<body>
<?php 
	if($_SESSION["loggedin"]==0){
		if(isset($_POST['submit'])){
			$username=$_POST["username"];
			$password=$_POST["password"];
			$confirm=$_POST["confirm"];
			$email=$_POST["email"];
			if($password == $confirm){
				if(isset($_POST['terms']) && $_POST['terms'] == 'Yes'){
				//can only register if accepts terms of use
					$result = $conn->query("INSERT INTO users(username,email,password,is_artist) VALUES ('$username','$email','$password',FALSE)");
					if(!$result){
						die("Error when registering.");
					}
					else{
						echo "Registered successfully, please login to validate.";
						header('Location: login.php');
					}
				}
				else{
					echo "You can not register without accepting the terms of use.";
				}
			}
			else{
				echo "Password confirmation not valid.";
			}
		}
	}
	else{
		echo "Cannot register while logged in.";
	}
?>

<!-- validar caracteres nos fields do form para nao haver injeccao de codigo-->
	<form class="form" action="register.php" method="post">
		<div class="form-register-login">

                	<div class="form-white-background">
				<div class="form-title-row">
                        		<h1>Register</h1>
                    		</div>
				<div class="form-row">
					<label>
						<span>Username</span>
						<input type="text" name="username" required>
					</label>
				</div>
				<div class="form-row">
					<label>
						<span>Email</span>
						<input type="email" name="email" required>
					</label>
				</div>
				<div class="form-row">
					<label>
						<span>Password</span>
						<input type="password" name="password" required>
					</label>
				</div>
				<div class="form-row">
					<label>
						<span>Confirm password</span>
						<input type="password" name="confirm" required>
					</label>
				</div class="form-row">
				<div>
					<label class="form-checkbox">
						<input type="checkbox" name="terms" value="Yes"> 
						<span>I have read and accept our <a href="terms.html">Terms of Use</a></span>
					</label>
				</div>
				<div class="form-row">
					<button type="submit" name="submit">Register</button>
				</div>
				Already have an account?<a href="login.php" class="form-log-in-with-existing">Login here</a>
			</div>
		</div>
	</form>
	


<?php $conn->close();?>
</body>
</html>