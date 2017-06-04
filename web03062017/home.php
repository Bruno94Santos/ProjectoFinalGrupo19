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
<?php

$result = $conn->query("SELECT * FROM events LIMIT 0,3");
if ($result) {
    while ($linha = $result->fetch_array(MYSQLI_ASSOC)) {
        $linha = mysqli_fetch_assoc($result);
        echo "<div class='thumbnail'>";
        echo "<h3>" . $linha['event_name'] . "</h3>";
        echo "<p>" . $linha['event_time'] . "</p>";
        echo "<p>" . $linha['location'] . "</p>";
        echo "<p>" . $linha['price'] . "</p>";
        echo "<p><a href='event.php?id=" . $linha["id"] . "' class='btn btn-primary' role='button'>More Info</a></p>";
        echo "</div>";

    }
    echo "<button class='btn btn-default center-block' name='submit'>Show More</button>";
} else {
    echo "Could not establish connection.";
}

if (isset($_POST['submit'])) {
    header("Location:events.php");
}

?>

</body>
</html>