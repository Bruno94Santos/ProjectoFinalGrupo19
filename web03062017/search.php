<?php 
function search($type, $string){
	if ($type==1){
		$result = $conn->query("SELECT * FROM artists WHERE name LIKE '%$string%'");
		if($result){
			echo "<div class='container'>";
			if (mysqli_num_rows($result) > 0) {
				while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
					echo "<div><a href='artist.php?id=".$linha['artist_id']."'>".linha["name"]."</a></div>";
				}
			}
			else{
				echo "<div class='alert alert-info'>No artists found.</div>";
			}
			echo "</div>";
		}
		else{
			echo "<div class='alert alert-danger'>Could not establish connection.</div>";
		}
	}	
	else{
		$result = $conn->query("SELECT * FROM events WHERE event_name LIKE '%$string%'");

		if($result){
			echo "<div class='container'>";
			if (mysqli_num_rows($result) > 0) {
				while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
					echo "<div><a href='event.php?id=".$linha['id']."'>".linha["event_name"]."</a></div>";
				}
			}
			else{
				echo "<div class='alert alert-info'>No events found.</div>";
			}
			echo "</div>";
		}
		else{
			echo "<div class='alert alert-danger'>Could not establish connection.</div>";
		}
	}
}
?>