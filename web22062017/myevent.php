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
    <title>Your event pages</title>

</head>

<body>
<?php include "header.php"; ?>
<?php
/*echo "<div class='jumbotron'>";*/
echo "<div class='container'>";
echo "<h2>My event pages</h2>";

    $user_id = $_SESSION["id"];
    $result = $conn->query("SELECT * FROM events WHERE creator_id = $user_id");
    if ($result) {
        while ($linha = $result->fetch_array(MYSQLI_ASSOC)) {
            echo '<div style=" border: solid gainsboro;border-radius: 10px; border-width: 2px; margin-bottom: 2px;"  class="col-xs-12">
                <a href="event.php?id=' . $linha["id"] . '">
                    <div class="col-xs-2">
                    <img class="img-responsive" src="http://placehold.it/100x70">
                    </div>
                    <div class="col-xs-7">
                        <h4 class="product-name">
                            <strong>' . $linha['event_name'] . '</strong>
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
        echo "<br><div>Do you have an event you want to host? You can always create <a href='createevent.php'>an event</a> or <a href='createjam.php'>a jam session</a>.</div>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-success'>Could not establish connection.</div>";
        echo "</div>";
    }

/*echo "</div>";*/
?>
<?php $conn->close(); ?>
</body>
</html>
