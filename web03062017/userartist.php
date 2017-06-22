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
    <title>Your artist pages</title>
    <?php include "header.php"; ?>
</head>

<body>
<?php include "header.php"; ?>
<?php
echo "<div class='container'>";
echo "<h2>My artist pages</h2>";
if ($_SESSION["is_artist"] == 1) {
    $user_id = $_SESSION["id"];
    $result = $conn->query("SELECT * FROM artists WHERE id = $user_id");
    if ($result) {
        while ($linha = $result->fetch_array(MYSQLI_ASSOC)) {
            /*//echo "<div class='container'>";
            echo "<div><a href='artist.php?id=" . $linha["artist_id"] . "'>" . $linha["name"] . "</a></div>";
            echo "<div>" . $linha["description"] . "</div>";
            header("Content-type: image/jpeg");
	    echo '<div class="profile-header-img"><img object-fit: contain" class="img-responsive" src="data:image/*;base64,'. base64_encode($linha["picture"]) . '"/></div>'; //VER DA IMAGEM
	    //<img class="img-responsive" src="http://placehold.it/100x70">
            //echo "</div>";*/
            echo '<div class="col-xs-12 line_artist">
                <a href="artist.php?id=' . $linha["artist_id"] . '">
                    <div class="col-xs-2">
                    <img class="img-responsive pic" src="data:image/*;base64,'. base64_encode($linha["picture"]) . '"/>
		    </div>
                    <div class="col-xs-7">
                        <h4 class="product-name">
                            <strong>' . $linha['name'] . '</strong>
                        </h4>
                        <h4 id = "descricao">
                            <small>' . $linha['description'] . '</small>
                        </h4>
                    </div>
                    <div class="col-xs-1">
			<h4 class="product-name">
                            <strong>' . $linha['location'] . '</strong>
			</h4>
                    </div>
                </a>
            </div>';
        }
        echo "<br><div>Do you have another band or solo artist name not listed here? You can always <a href='createartist.php'>create another artist page</a>.</div>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-success'>Could not establish connection.</div>";
        echo "</div>";
    }
} else {
    echo "<div>You don't have any artist pages of your own. Why not <a href='createartist.php'>create one</a> and start uploading the music you create today?</div>";
    echo "</div>";
}
/*echo "</div>";*/
?>
<?php $conn->close(); ?>
</body>
</html>
