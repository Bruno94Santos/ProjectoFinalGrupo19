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
<?php
include "header.php";
$id = $_GET["id"];

$data = json_decode(file_get_contents("php://input"));
// function get_events_by_page($page){
$result = $conn->query("SELECT * FROM events LIMIT 0,3");/* TODO $page,3*/
$output = "";
if ($result) {
    while ($linha = $result->fetch_array(MYSQLI_ASSOC)) {
        $linha = mysqli_fetch_assoc($result);
        echo "<div class='thumbnail'>";
        echo "<h3>" . $linha['event_name'] . "</h3>";
        echo "<p>" . $linha['event_time'] . "</p>";
        echo "<p>" . $linha['location'] . "</p>";
        /* echo "<p>".$linha['price'] ."</p>";*/
        echo "<p><a href='concert.php?id=" . $linha["id"] . "' class='btn btn-primary' role='button'>More Info</a></p>";
        "</div>";

    }
    $output = '{"records":[' . $output . ']}';
    return $output;
} else {
    echo "Could not establish connection.";
}
?>

<button class="btn btn-default center-block" name="submit">Show More</button>


<?php $conn->close(); ?>
</body>
</html>