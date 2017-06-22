<?php
session_start();
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
    <title>Event</title>
</head>

<body>
<?php include "header.php"; ?>
<div class="container">
    <div class="row" style="padding-left: 10%; padding-right: 10%">
                    <div class="col-md-6 col-xs-12">
                        <img style="height: 100%; width: 100%" src="http://placehold.it/570x470">
                        <!--<img src="http://placehold.it/570x470">-->
                    </div>
                    <div class="col-md-6 col-xs-12">
        <?php
        $id = $_GET["id"];
	$is_artist = $_SESSION["is_artist"];

        $user_id = $_SESSION["id"];
        $result = $conn->query("SELECT * FROM events WHERE id = $id");
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $linha = mysqli_fetch_assoc($result);
                $creator_id = $linha["creator_id"];
                $jam = $linha["is_jam"];
                $description = $linha["description"];
                $price = $linha["price"];
                $total_seats = $linha["total_seats"];
                $seats_taken = $linha["seats_taken"];
                $sold_out = $linha["sold_out"];
                $event_time = $linha["event_time"];
                $result1 = $conn->query("SELECT *, DATE(event_time)<DATE(NOW()) as event_over FROM events WHERE id = $id");
                $row = $result1->fetch_array(MYSQLI_ASSOC);
		if ($linha['price'] == 0.00) {
                $price = 'FREE';
            	}
		else{
		$price= $linha['price']."€ per ticket";
		}
                echo '
                        <h2>'.$linha["event_name"].'</h2>
                        <h6>Time: '.$linha["event_time"].'</h6>
                        <h6>Local: '.$linha["location"].'</h6>
                        <p>'.$linha["description"].'</p>
                        <div class="pull-bottom"><h4>Price: '.$price.'</h4>';

		if($jam==0){
			$result = $conn->query("SELECT * FROM eparticipants, artists WHERE artists.artist_id=eparticipants.artist_id AND eparticipants.event_id = $id");
			if($result){
			if (mysqli_num_rows($result)>0){
				$linha=mysqli_fetch_assoc($result);
				echo "Featuring artist ".$linha["name"].'<br>';
			}
			else{echo "<div class='alert alert-danger'>Could not connect to database.</div>";}
			}
		}
                if ($row['event_over'] == 1) {
                    echo "<p style='color: red'>This event is over.</p>";
                } else {
                    if ($total_seats > $seats_taken) {
			if($price!='FREE'){
                        echo "<a href='buyticket.php?id=" . $id . "'>Buy ticket</a>";
                    }
		    } else {
                        echo "<p style='color: red'>This event is currently sold out.</p>";
                    }
                }
		if($jam==1 && $sold_out==0){
			signup($conn,$user_id,$id,$is_artist);
		}
		echo '</div></div>';
               
            } else {
                echo "<div class='alert alert-danger'>There was an error fetching this event. The page might have been deleted.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Could not establish connection.</div>";
        }



function signup($conn,$user_id,$id,$is_artist){
if ($is_artist==1) {
	if (isset($_POST['submit'])) {
		$artist = $_POST["artist"];
		$result = $conn->query("INSERT INTO eparticipants(event_id,artist_id) VALUES($id,$artist)");
		if ($result){
			echo "<div class='alert alert-success fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>You signed up successfully!</div>";
			echo '<meta http-equiv="refresh" content="0; URL=event.php?id='.$id.'">';
		}
		else{
			echo "<div class='alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Was not able to sign up.</div>";
		}
	}
	$result = $conn->query("SELECT * FROM artists WHERE id=$user_id AND artist_id NOT IN (SELECT artist_id FROM eparticipants WHERE event_id=$id)");
        if (!$result) {
		die("<div class='alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>You don't have any artist pages of your own to sign up.<a href='createartist.php'><strong> Create one.</strong></a></div>");
        } else {
			if (mysqli_num_rows($result)>0){
				echo "<form method='post' class='createartist' action='event.php?id=".$id."'><div class='form-group float-label-control'>";
				echo "<label>Sign up as: <select class='form-control' name='artist'>";
				echo "<option value='' selected='selected'>Select One</option>";
				while ($linha = $result->fetch_array(MYSQLI_ASSOC)) {
					echo"<option value='".$linha["artist_id"]."'>".$linha["name"]."</option>";
				}
			echo "</select></label></div><input type='submit' name='submit' value='Sign up' class='btn btn-default center-block'></form>";
			}
        }
}
else{
	echo "<div class='alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>You don't have any artist pages of your own to sign up to this event.<a href='createartist.php'><strong> Create one.</strong></a></div>";

}
}




        $conn->close(); ?>
    </div>
</div>
</body>
</html>