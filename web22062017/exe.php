<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>TorontoWebsiteDeveloper Bootstrap Tutorials</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
	<?php
	if($_POST["submit"]){
		function_search($_POST["choice"],$_POST["search"]);
	}
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
	<form action="" method="post">
			<input type="text" name="search" placeholder="Search...">
			<input type="checkbox" name="choice" value="1">artist
			<input type="checkbox" name"choice" value="0">event
			<input type="submit" name="submit" value="Go"> 
	</form>
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	-->
    </body>
</html>