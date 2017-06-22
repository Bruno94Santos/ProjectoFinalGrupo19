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
    <title>Home</title>
</head>
<body>
<?php include "header.php"; ?>
<div class='container'>
    <!--<h2>Musin</h2>
	<h3>Made for indie music</h3>-->

    <?php

    $result = $conn->query("SELECT * FROM events LIMIT 0,3");
    if ($result) {
echo "<h4>Popular events</h4>";
        while ($linha = $result->fetch_array(MYSQLI_ASSOC)) {
            if (intval($linha['total_seats']) > intval($linha['seats_taken'])) {
                /*$linha = mysqli_fetch_assoc($result);
                echo "<div class='thumbnail'>";
                echo "<h3>" . $linha['event_name'] . "</h3>";
                echo "<p>" . $linha['event_time'] . "</p>";
                echo "<p>" . $linha['location'] . "</p>";
                echo "<p>" . $linha['price'] . "</p>";
                echo "<p><a href='event.php?id=" . $linha["id"] . "' class='btn btn-primary' role='button'>More Info</a></p>";
                echo "</div>";*/
                echo '<div style=" border: solid gainsboro;border-radius: 10px; border-width: 2px; margin-bottom: 2px;"  class="col-xs-12">
                <a href="event.php?id=' . $linha["id"] . '">
                    <div class="col-xs-2">
                    <img class="img-responsive" src="http://placehold.it/100x70">
                    </div>
                    <div class="col-xs-4">
                        <h4 class="product-name">
                            <strong>' . $linha['event_name'] . '</strong>
                        </h4>
                        <h4>
                            <small>' . $linha['description'] . '</small>
                        </h4>
                    </div>
                    <div class="col-xs-2">';
                if ($linha['price'] == 0.00) {
                    echo '<strong>Price: FREE</strong>';
                } else {
                    echo '<strong>Price: ' . $linha['price'] . '€ </strong >';
                }
                echo '</div>
                <div class="col-xs-1">
                        <strong>' . $linha['location'] . '</strong>
                    </div>
                </a>
            </div>';

            }
        }
        //echo "<button class='btn btn-default center-block' name='submit'>Show More</button>";
    } else {
        echo "Could not establish connection.";
    }

    if (isset($_POST['submit'])) {
        header("Location:events.php");
    }
echo "<br><h4>Popular Artists</h4>";

    $result = $conn->query("SELECT * FROM artists LIMIT 0,3");
    if ($result) {
        while ($linha = $result->fetch_array(MYSQLI_ASSOC)) {
            /*$linha = mysqli_fetch_assoc($result);
            echo "<div class='thumbnail'>";
            echo "<h3>" . $linha['song'] . "</h3>";
            echo "<p>" . $linha['artist'] . "</p>";
            echo "<p>" . $linha['media'] . "</p>";
            echo "<p><a href='concert.php?id=" . $linha["id"] . "' class='btn btn-primary' role='button'>More Info</a></p>";
            "</div>";*/
            echo '<div style=" border: solid gainsboro;border-radius: 10px; border-width: 2px; margin-bottom: 2px;"  class="col-xs-12">
                <a href="artist.php?id=' . $linha["artist_id"] . '">
                    <div class="col-xs-2">
                    <img class="img-responsive" src="http://placehold.it/100x70">
                    </div>
                    <div class="col-xs-7">
                        <h4 class="product-name">
                            <strong>' . $linha['name'] . '</strong>
                        </h4>
                        <h4>
                            <small>' . $linha['description'] . '</small>
                        </h4>
                    </div>
                    <div class="col-xs-1">
                        <strong>' . $linha['location'] . '</strong>
                    </div>
                </a>
            </div>';


        }
	echo "<center><h5>Made for indie music. <a href='terms.html'>Terms of Use</a></h5></center>";
        //echo "<button class='btn btn-default center-block' name='submit'>Show More</button>";
    } else {
        echo "Could not establish connection.";
    }


    ?>
</div>
</body>
</html>