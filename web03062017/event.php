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
        <?php
        $id = $_GET["id"];


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
                echo '
                    <div class="col-md-6 col-xs-12">
                        <img style="height: 100%; width: 100%" src="http://placehold.it/570x470">
                        <!--<img src="http://placehold.it/570x470">-->
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <h2>'.$linha["event_name"].'</h2>
                        <h6>Time: '.$linha["event_time"].'</h6>
                        <h6>Local: '.$linha["location"].'</h6>
                        <p>'.$linha["description"].'</p>
                        <div class="pull-bottom"><h4>Price: '.$linha["price"].'€ per ticket</h4>';
                if ($row['event_over'] == 1) {
                    echo "<p style='color: red'>This event is over.</p>";
                } else {
                    if ($total_seats > $seats_taken) {
                        echo "<a href='buyticket.php?id=" . $id . "'>Buy ticket</a>";
                    } else {
                        echo "<p style='color: red'>This event is currently sold out.</p>";
                    }
                }echo '</div></div>';
               /* echo $linha["event_name"];
                echo $linha["event_time"];
                echo $linha["sold_out"];

                echo $linha["location"];

                echo $linha["seats_taken"] . " of " . $linha["total_seats"] . " seats taken.";
                echo $linha["price"] . "€ per ticket";

                if ($row['event_over'] == 1) {
                    echo "This event is over.";
                } else {
                    if ($total_seats > $seats_taken) {
                        echo "<a href='buyticket.php?id=" . $id . "'>Buy ticket</a>";
                    } else {
                        echo "This event is currently sold out.";
                    }
                }*/
            } else {
                echo "There was an error fetching this event. The page might have been deleted.";
            }
        } else {
            echo "Could not establish connection.";
        }


        $conn->close(); ?>
    </div>
</div>
</body>
</html>