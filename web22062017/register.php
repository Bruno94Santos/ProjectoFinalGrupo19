<?php 
session_start();
//define('APPLICATION', true);
include "../inc/dbinfo.inc";
if (!isset($_SESSION["loggedin"])) {
    $_SESSION["loggedin"] = 0;
}
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Register</title>
    <!--<link rel="stylesheet" href="css/form.css">-->
    <!-- Latest compiled and minified CSS -->
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

if ($_SESSION["loggedin"] == 0) {
    if (isset($_POST['submit'])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirm = $_POST["confirm"];
        $email = $_POST["email"];
        if ($password == $confirm) {
            if (isset($_POST['terms']) && $_POST['terms'] == 'Yes') {
                //can only register if accepts terms of use
		$pass = md5($password);
                $result = $conn->query("INSERT INTO users(username,email,password,is_artist) VALUES ('$username','$email','$pass',FALSE)");
                if (!$result) {
                    die("Error when registering.");
                } else {
                    echo "Registered successfully, please login to validate.";
                    header('Location: login.php');
                }
            } else {
                echo "You can not register without accepting the terms of use.";
            }
        } else {
            echo "Password confirmation not valid.";
        }
    }
?>

<!-- validar caracteres nos fields do form para nao haver injeccao de codigo-->
<div class="container" >
    <div class="row" class="main">
        <div class=".col-xs-6 .col-lg-12 col-sx-offset-1">
            <h4 class="page-header">Register</h4>
            <form action="register.php" method="post">
                <div class="form-group float-label-control">
                    <label form="">Username</label>
                    <input class="form-control" type="text" name="username" required>
                </div>
                <div class="form-group float-label-control">
                    <label for="">Email</label>
                    <input class="form-control" type="email" name="email" required>
                </div>
                <div class="form-group float-label-control">
                    <label for="">Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>
                <div class="form-group float-label-control">
                    <label for="">Confirm password</label>
                    <input class="form-control" type="password" name="confirm" required>
                </div>
                 <div class="form-group float-label-control">
                     <div>
                         <label class="form-checkbox">
                             <input type="checkbox" name="terms" value="Yes">
                             <span>I have read and accept our <a href="terms.html">Terms of Use</a></span>
                         </label>
                     </div>
                 </div>
                 <div class="form-group">
                     <button class="btn btn-default center-block" type="submit" name="submit">Register</button>
                 </div>
                Already have an account?<a href="login.php" class="form-log-in-with-existing"> Login</a>
            </form>
        </div>
    </div>
</div>
</div>
<?php
} else {
?>
	<div class='alert alert-danger'>
    		<strong>Cannot register while logged in.</strong>
	</div>
<?php
}
?>
<?php $conn->close(); ?>
</body>
</html>