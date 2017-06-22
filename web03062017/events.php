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
    <meta name="viewport" content="width=device-width">
    <title>Events</title>
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
<div class='container'>
    <h2>Events</h2>
    <?php
    include "header.php";
    $id = $_GET["id"];
    $data = json_decode(file_get_contents("php://input"));
    // function get_events_by_page($page){
    $result = $conn->query("SELECT * FROM events");/* TODO $page,3*/
    if ($result) {
        while ($linha = $result->fetch_array(MYSQLI_ASSOC)) {
            /*$linha = mysqli_fetch_assoc($result);*/
            echo '<div style=" border: solid gainsboro;border-radius: 10px; border-width: 2px; margin-bottom: 2px;"  class="col-xs-12">
                <a href="event.php?id=' . $linha["id"] . '">
                    <div class="col-xs-2">
                    <img class="img-responsive" src="http://placehold.it/100x70">
                    </div>
                    <div class="col-xs-4">
                        <h4 class="product-name">
                            <strong>' . $linha['event_name'] . '</strong>
                        </h4>
                        <small>' . $linha['description'] . '</small>
                    </div>
                    <div class="col-xs-2">';
            if ($linha['price'] == 0.00) {
                echo '<strong>Price: FREE</strong>';
            } else {
                echo '<strong>Price: ' . $linha['price'] . '€ </strong >';
            }
            echo '</div>
                  <div class="col-xs-2">';
            if (intval($linha['total_seats']) <= intval($linha['seats_taken'])) {
                echo '<p style="color: red">Esgotado</p>';
            }

            echo '</div>
                    <div class="col-xs-1">
                        <strong>' . $linha['location'] . '</strong>
                    </div>
                </a>
            </div>';
            /*echo "<div class='thumbnail'>";
            echo "<h3>" . $linha['event_name'] . "</h3>";
            echo "<p>" . $linha['event_time'] . "</p>";
            echo "<p>" . $linha['location'] . "</p>";
            echo "<p>".$linha['price'] ."</p>";
            echo "<p><a href='concert.php?id=" . $linha["id"] . "' class='btn btn-primary' role='button'>More Info</a></p>";
            "</div>";*/

        }
    } else {
        echo "<p>Could not establish connection.</p>";
    }
    ?>

    <!--<button class="btn btn-default center-block" name="submit">Show More</button>-->
</div>
<?php $conn->close(); ?>
</body>
</html>