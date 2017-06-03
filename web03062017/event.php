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
	<title>Event</title>
</head>

<body>
	<?php
	$id=$_GET["id"];
	
	?>
	
<?php $conn->close();?>
</body>
</html>