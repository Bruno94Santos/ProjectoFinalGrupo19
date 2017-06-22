<?php 
session_start();
//define('APPLICATION', true);
include "../inc/dbinfo.inc";
if (!isset($_SESSION["loggedin"])) {
    $_SESSION["loggedin"] = 0;
}
$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width">
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
    if (isset($_POST["submit"])) {
        $username = $_POST["username"];
        $password = md5($_POST["password"]);
	$result = $connection->query("SELECT * FROM users WHERE (username='$username' OR email='$username') AND PASSWORD='$password';");
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $linha = mysqli_fetch_assoc($result);
                $_SESSION["username"] = $username;
                $_SESSION["id"] = $linha['id'];
                //$_SESSION["picture"]=$linha["picture"];
                $_SESSION["email"] = $linha["email"];
                //$_SESSION["bio"]=$linha["bio"];
                $_SESSION["is_artist"] = $linha["is_artist"];
                $_SESSION["loggedin"] = 1;
                $_SESSION["admin"] = 0;

                header('Location: home.php');
            } else {
                echo "<div class='alert alert-danger'>Username/email does not exist.</div>";
            }
        } else {
                echo "<div class='container'><div class='alert alert-danger'>Could not establish connection.</div></div>";
        }
    }

?>

<div class="container">
 <div class="row" class="main">
  <div class=".col-xs-6 .col-lg-12 col-sx-offset-1">
    <h4 class="page-header">Login</h4>
     <form action="login.php" method="post">
        <div class="form-group float-label-control">
             <label form="">Username</label>
             <input class="form-control" type="text" name="username" required>
         </div>
         <div class="form-group float-label-control">
              <label for="">Password</label>
              <input class="form-control" type="password" name="password" required>
         </div>
         <div class="form-group">
               <button class="btn btn-default center-block" type="submit" name="submit">Login</button>
         </div>
         If you don't have an account<a href="register.php" class="form-log-in-with-existing"> sign up here</a>
    </form>
  </div>
 </div>
</div>
<?php
} else {
?><div class="container">
	<div class="alert alert-danger" >
    		<strong>Valid session already active.</strong>
	</div></div>
<?php
}
?>

<?php $connection->close(); ?>

</body>
</html>
