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
	<?php include "header.php";?>
	<?php
	if($_SESSION["loggedin"]==1){
		if(isset($_POST['submit'])){
			$user_id=$_SESSION["id"];
			if(!isset($_SESSION["event"])){
				$_SESSION["event"]+=1;
			}
			else{
				$_SESSION["event"]=1;
			}
			$event_name=$_POST["name"];
			$event_time=$_POST["datetime"];
			$location=$_POST["location"];
			$description=$_POST["description"];
			$total_seats=$_POST["number"];
			$picture=$_POST["picture"];
			//verificar como se faz upload de imagem lol
			$result = $conn->query("INSERT INTO events(creator_id,picture,event_name,event_time,location,description, total_seats,seats_taken,price,sold_out,rating_sum,rating_n,is_jam) VALUES ($user_id,'$picture','$event_name','$event_time','$location','$description',$total_seats,0,$price,FALSE,0,0,$is_jam)");
			if(!$result){
				die("Error when creating event.");
			}
			else{
				echo "Created event with success.";
			}
		}
	}
	else{
		echo "You must be loged in to create an event.";
	}
	
	?>
	
<center>
<!-- validar caracteres nos fields do form para nao haver injeccao de codigo-->
	<?php 
	if ($_SESSION["event"]<=3){ 
	?>
	<form class="createartist" action="createartist.php" method="post">
		<label>Event name:</label><br>
			<input type="text" name="name" required><br>
		<label>Description:</label><br>
			<input type="text" name="description"><br>
		<label>Location:</label><br>
			<input type="text" name="location"><br>
		<label>Event type:</label></br>
			<input type="radio" name="optradio" value="0" checked="checked">Concert<br>
			<input type="radio" name="optradio" value="1">Jam session<br>
		<label>Ticket price:</label><br>
			<input type="checkbox" name="free" checked="checked" value="free" />Free<br>
			<input type="number" min="0.00" max="10000.00" step="0.01" />€<br>
		<label>Event time:</label><br>
			<input type="datetime-local" id="datetime"><br>

		<label>Number of tickets:</label><br>
			<input type="int" name="number" placeholder="50"><br>
		<label>Cover image:</label><br>
			input type="file" name="picture" accept="image/*"><br><!--ver da imagem-->
		<br>
		<input type="submit" name='submit' value="Create">
	</form>
	<?php }
	else{
		echo "You've created too many events in a row. Please wait before trying again.";
	}
	?>
</center>

	<?php $conn->close();?>
</body>
</html>
