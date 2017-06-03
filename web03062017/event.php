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
	<?php include "header.php";?>
	<?php
	$id=$_GET["id"];
	
	$user_id=$_SESSION["id"];
	$result = $conn->query("SELECT * FROM events WHERE id = $id");
	if($result){
		if (mysqli_num_rows($result)>0){
			$linha=mysqli_fetch_assoc($result);
			$creator_id = $linha["creator_id"];
			echo $linha["event_name"];
			echo $linha["event_time"];
			echo $linha["sold_out"];
			$jam = $linha["is_jam"];
			echo $linha["location"];
			$description = $linha["description"];
			echo $linha["seats_taken"] . " of " . $linha["total_seats"] . " seats taken.";
			echo $linha["price"] . "€ per ticket";
			$price = $linha["price"];
			$total_seats = $linha["total_seats"];
			$seats_taken = $linha["seats_taken"];
			$sold_out = $linha["sold_out"];
			$event_time = $linha["event_time"];
			
			$result1 = $conn->query("SELECT *, DATE(event_time)<DATE(NOW()) as event_over FROM events WHERE id = $id");
			$row = $result1->fetch_array(MYSQLI_ASSOC);
			if ($row['event_over'] == 1) {
				echo "This event is over.";
			}
			else{
				if ($total_seats > $seats_taken){
					echo "<a href='buyticket.php?id=". $id ."'>Buy ticket</a>" ;
				}
				else{
					echo "This event is currently sold out.";
				}
			}
		}
		else{
			echo "There was an error fetching this event. The page might have been deleted.";
		}
	}
	else{
		echo "Could not establish connection.";
	}
	
	
	?>

	
	
<?php $conn->close();?>
</body>
</html>