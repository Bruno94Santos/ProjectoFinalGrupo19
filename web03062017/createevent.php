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
	<title>Create event page</title>
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
<?php include "header.php"; ?>
<?php
if ($_SESSION["loggedin"] == 1) {
$user_id = $_SESSION["id"];
    if (isset($_POST['submit'])) {
        if (!isset($_SESSION["event"])) {
            $_SESSION["event"] += 1;
        } else {
            $_SESSION["event"] = 1;
        }
        $event_name = htmlspecialchars($_POST["name"]);
        $event_time = htmlspecialchars($_POST["datetime"]);
        $location = htmlspecialchars($_POST["location"]);
        $description = htmlspecialchars($_POST["description"]);
        $total_seats = htmlspecialchars($_POST["number"]);
	$price = htmlspecialchars($_POST["price"]);
        $picture = $_POST["picture"];
	$artist = htmlspecialchars($_POST["artist"]);
        //verificar como se faz upload de imagem lol
        $result = $conn->query("INSERT INTO events(creator_id,picture,event_name,event_time,location,description, total_seats,seats_taken,price,sold_out,rating_sum,rating_n,is_jam) VALUES ($user_id,'$picture','$event_name','$event_time','$location','$description',$total_seats,0,$price,0,0,0,0)");
        if (!$result) {
            die("<div class='alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error when creating event.</div>");
        }
	else {
		$event_id = $conn->insert_id;
		$result1 = $conn->query("INSERT INTO eparticipants(event_id,artist_id) VALUES ($event_id,$artist)");
        	if (!$result1) {
            		die("<div class='alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error when creating event.</div>");
		}
		else{
			echo "<div class='alert alert-success fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Created event with success.</div>";
			echo '<meta http-equiv="refresh" content="0; URL=myevent.php">';

        	}
	}
    }
}
else {
    echo "<div class='alert alert-danger'>You must be logged in to create an event.</div>";
}

?>

<!-- validar caracteres nos fields do form para nao haver injeccao de codigo-->
<?php
if ($_SESSION["event"] <= 3) {
    ?>
    <div class="container">
        <div class="row" style="padding-left: 10%; padding-right: 10%; padding-bottom: 10%">
            <div class=".col-xs-6 .col-lg-12 col-sx-offset-1">
                <h4 class="page-header">Create event</h4>
		<form class="createartist" action="" method="post">
                    <div class="form-group float-label-control">
                        <label for="">Event name</label>
                        <input class="form-control" type="text" name="name" maxlength="60" required><br>
                    </div>
                    <div class="form-group float-label-control">
                        <label for="">Description</label>
                        <textarea class="form-control" rows="4" name="description" maxlength="500"></textarea>
                    </div>
                    <div class="form-group float-label-control">
                        <label for="">Location</label>
                        <input class="form-control" type="text" name="location">
                    </div>
                    <div class="form-group float-label-control">
                        <label for="">Ticket price</label>
                        <input class="form-control" name="price" type="number" min="0.00" max="10000.00" step="0.01" value="0.00"/>€
                    </div>
                    <div class="form-group float-label-control">
                        <label for="">Event time</label>
                        <input class="form-control" name="datetime" type="datetime-local" id="datetime-local" value="YYYY-MM-DD HH:MM">
                    </div>
                    <div class="form-group float-label-control">
                        <label for="">Number of tickets</label>
                        <input class="form-control" type="number" name="number" value="50">
                    </div>

<?php
	$result = $conn->query("SELECT * FROM artists WHERE id=$user_id");
        if (!$result) {
            die("<div class='alert alert-danger fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>You don't have any artist pages of your own. <a href='createartist.php'><strong>Create one.</strong></a></div>");
        } else {
		if (mysqli_num_rows($result)>0){
		echo "<div class='form-group float-label-control'>";
		echo "<label>Artist</label><select class='form-control' name='artist'>";
		echo "<option value='' selected='selected'>Select One</option>";
		while ($linha = $result->fetch_array(MYSQLI_ASSOC)) {
			echo"<option value='".$linha["artist_id"]."'>".$linha["name"]."</option>";
		}
		echo "</select></div>";
		}
        }
?>

                    <div class="form-group float-label-control">
                        <label for="">Cover image</label>
                        <input type="file" name="picture" accept="image/*"><br><!--ver da imagem-->
                    </div>
		<button type="submit" name="submit" class="btn btn-default center-block">Create</button>
		</form>
            </div>
        </div>
    </div>
<?php } else {
    echo "<div class='alert alert-danger'>You've created too many events in a row. Please wait before trying again.</div>";
}
?>

<?php $conn->close(); ?>
</body>
</html>
