<?php
session_start(); //on index top
include "../inc/dbinfo.inc";

if(!isset($_SESSION["loggedin"])){
    $_SESSION["loggedin"]=0;
}


$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

/*
$output="";
$output .= '{"Username":"' . $_SESSION["username"] . '",';
$output .= '"UserID":"' . $_SESSION["id"] . '",';
$output .= '"UserPicture":"' . $_SESSION["picture"] . '",';
$output .= '"Email":"' . $_SESSION["email"] . '",';
$output .= '"IsArtist":"' . $_SESSION["is_artist"] . '",';
$output .= '"LoggedIn":"' . 1 . '",';
$output .= '"Admin":"' . 0 . '"}';
*/
$id = $_SESSION["id"];

$result = $conn->query("SELECT * FROM media WHERE id = $id LIMIT ,3");
if($result){
    if (mysqli_num_rows($result)>0){
        $linha=mysqli_fetch_assoc($result);
        echo "<div class='thumbnail'>";
        echo "<h3>".$linha['song']."</h3>";
        echo "<p>".$linha['artist']."</p>";
        echo "<p>".$linha['media'] ."</p>";
        echo "<p><a href='concert.php?id=".$linha["id"]."' class='btn btn-primary' role='button'>More Info</a></p>";
        "</div>";

        return $output;
    }
    else{
        echo "Cannot find media. Media might have been deleted.";
    }
}
else{
    echo "Could not establish connection.";
};

echo "<button class='btn btn-default center-block' name='submit'>Show More</button>";


$result = $conn->query("SELECT * FROM events LIMIT ,3");
if($result){
    while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
        $linha=mysqli_fetch_assoc($result);
        echo "<div class='thumbnail'>";
        echo "<h3>".$linha['event_name']."</h3>";
        echo "<p>".$linha['event_time']."</p>";
        echo "<p>".$linha['location']."</p>";
        echo "<p>".$linha['price'] ."</p>";
        echo "<p><a href='concert.php?id=".$linha["id"]."' class='btn btn-primary' role='button'>More Info</a></p>";
        echo "</div>";

    }
}
else{
    echo "Could not establish connection.";
}
echo "<button class='btn btn-default center-block' name='submit'>Show More</button>";


$conn->close();
?>