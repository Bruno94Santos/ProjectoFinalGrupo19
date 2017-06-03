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
	<title>Create artist page</title>
</head>

<body>
	<?php include "header.php"; ?>
	<?php
	if($_SESSION["loggedin"]==1){
		if(isset($_POST['submit'])){
			$user_id=$_SESSION["id"];
			if(!isset($_SESSION["artist"])){
				$_SESSION["artist"]+=1;
			}
			else{
				$_SESSION["artist"]=1;
			}
			$name=$_POST["name"];
			$location=$_POST["location"];
			$description=$_POST["description"];
			$picture=$_POST["picture"];
			//verificar como se faz upload de imagem lol
			$result = $conn->query("INSERT INTO artists(id,description,picture,location,name,rating_sum,rating_n) VALUES ($user_id,'$description','$picture','$location','$name',0,0)");
			$res = $conn->query("UPDATE users SET is_artist=TRUE WHERE id = $user_id");
			$_SESSION["is_artist"]=1;
			if(!$result || !$res){
				die("Error when creating artist.");
			}
			else{
				echo "Created artist with success.";
				header('Location: userartist.php');

			}
		}
	}
	else{
		echo "Can't create an artist without being logged in.";
	}
	
	?>
	
<center>
<!-- validar caracteres nos fields do form para nao haver injeccao de codigo-->

	<div class="container">
	<?php 
	if ($_SESSION["artist"]<=3){ 
	?>
		<form class="createartist" action="createartist.php" method="post">
			<div class="class="createartist-group">
				<label >Artist name</label>
				<input type="text" class="createartist-control" name="name" required />
			</div>
			<div class="class="createartist-group">
				<label>Biography</label>
				<input type="text" class="createartist-control" name="description" />
			</div>
			<div class="class="createartist-group">
				<label>Location</label>
				<input type="text" class="createartist-control" name="location" />
			<div class="class="createartist-group">
				<label>Picture</label>
				<input type="file" name="picture" accept="image/*" />
			</div>
			<div class="class="createartist-group">
				<input type="checkbox" name="terms" value="Yes" /> I have read and accepted our <a href="terms.html">Terms of Use, and will not be posting content I don't own or don't have permission to share.</a>
			</div>
			<button type="submit" class="btn btn-primary" name='submit'>Create</button>
		</form>
	<?php }
	else{
		echo "You've created too many artist pages in a row. Please wait before trying again.";
	}
	?>
	</div>
</center>

	<?php $conn->close();?>
</body>
</html>
