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
	<title>Your artist pages</title>
	
</head>

<body>
	<?php include "header.php"; ?>
	<?php
	echo "<div class='jumbotron'>";
	echo "<div class='container'>";
	if($_SESSION["is_artist"]==1){
		$user_id=$_SESSION["id"];
		$result = $conn->query("SELECT * FROM artists WHERE id = $user_id");
		if($result){
			while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
				//echo "<div class='container'>";
				echo "<div><a href='artist.php?id=".$linha["artist_id"]."'>".$linha["name"]."</a></div>";
				echo "<div>".$linha["description"]."</div>";
				echo "<div><img src='" . $linha["picture"] . "'></div>"; //VER DA IMAGEM
				//echo "</div>";
			}
			echo "<div>Do you have another band or solo artist name not listed here? You can always <a href='createartist.php'>create another artist page</a></div>.";
			echo "</div>";
		}
		else{
			echo "Could not establish connection.";
			echo "</div>";
		}
	}
	else{
		echo "<div>You don't have any artist pages of your own. Why not <a href='createartist.php'>create one</a> and start uploading the music you create today?</div>";
		echo "</div>";
	}
	echo "</div>";
	?>
	<?php $conn->close();?>
</body>
</html>
