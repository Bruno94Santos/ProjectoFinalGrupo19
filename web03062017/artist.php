<?php
session_start();
include "../inc/dbinfo.inc";
//include the S3 class              
if (!class_exists('S3')) require_once('S3.php');

//AWS access info
//ALTERAR QUANDO TIVERMOS ACCESS KEY
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIJQEB64PUI4B4MEQ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');

//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

if (!isset($_SESSION["loggedin"])) {
    $_SESSION["loggedin"] = 0;
}
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Artist</title>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
<?php include "header.php"; ?>
<?php
$id = $_GET["id"];
$user_id = $_SESSION["id"];
$result = $conn->query("SELECT * FROM artists WHERE artist_id = $id");
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $linha = mysqli_fetch_assoc($result);
        $artist_user_id = $linha["id"];
        /*
        echo "<div class='jumbotron'>";
        //VER DA CENA DA IMAGEM
        echo "<div class='container'>";
        echo "<div> <img src='" . $linha["picture"] . "'></div>";
        echo "<div>" . $linha["name"] . "</div>";
        echo "<div>" . $linha["location"] . "</div>";
        echo "<div>" . $linha["description"] . "</div>";
        echo "<div>" . $linha["rating_n"] . "</div>";
        echo "<div>" . $linha["rating_sum"] . "</div>";
        echo "<div>" . $linha["rating_n"] / $linha["rating_sum"] . "</div>";
        echo "</div>";
        echo "</div>";*/
        echo '<div class="container" style="margin-top: 30px;">
                <div class="profile-head">
                <div class="col-md- col-sm-4 col-xs-12">
                <img src="http://www.newlifefamilychiropractic.net/wp-content/uploads/2014/07/300x300.gif" class="img-responsive" />
                <h6>' . $linha["name"] . '</h6>
                </div><!--col-md-4 col-sm-4 col-xs-12 close-->
                <div class="col-md-5 col-sm-5 col-xs-12">
                <h5>' . $linha["name"] . '</h5>
                <p>Rating: ' . (intval($linha["rating_n"]) / intval($linha["rating_sum"])) . '</p>
                <p>Descrição: ' . $linha["description"] . '</p>
                <!--<ul>
                <li><span class="glyphicon glyphicon-briefcase"></span> 5 years</li>
                <li><span class="glyphicon glyphicon-map-marker"></span> U.S.A.</li>
                <li><span class="glyphicon glyphicon-home"></span> 555 street Address,toedo 43606 U.S.A.</li>
                <li><span class="glyphicon glyphicon-phone"></span> <a href="#" title="call">(+021) 956 789123</a></li>
                <li><span class="glyphicon glyphicon-envelope"></span><a href="#" title="mail">jenifer123@gmail.com</a></li>
                </ul>-->            
                </div><!--col-md-8 col-sm-8 col-xs-12 close-->
                </div><!--profile-head close-->
                </div><!--container close-->';
    } else {
        echo "<div class='alert alert-danger'>There was an error fetching this artist. This page might have been deleted.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Could not establish connection.</div>";
}

echo '<div class="container">';

//UPLOAD DE MUSICAS
if ($artist_user_id == $user_id) {
    echo '
    <ul class="nav nav-tabs nav-menu" role="tablist">
      <li>
          <a href="upload.php?id=' . $id . '" role="button">
              add new track
          </a>
      </li>
      <li>
        <a href="uploadvideo.php?id=' . $id . '" role="button">
          add new video
        </a>
      </li>
    </ul>';
    /*echo "<div><a href='upload.php?id=" . $id . "'>Upload a new track.</a></div>";
    echo "<div><a href='uploadvideo.php?id=" . $id . "'>Upload a new video.</a></div>";*/
    //FEITO
}


//MUSICAS DO ARTISTA/DOWNLOAD DE MUSICAS
$result = $conn->query("SELECT * FROM media WHERE artist = $id AND song=TRUE");
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while ($linha = $result->fetch_array(MYSQLI_ASSOC)) {
            echo "<div>";
            $media_id = $linha["id"];
            $is_song = $linha["song"];
            download($conn, $media_id, $s3);
            echo "<div>" . $linha["description"] . "</div>";
            if ($linha["rating_n"]  > 0) {
                echo "<div>" . round($linha["rating_sum"] / $linha["rating_n"],2) . "</div>";
            }
            echo "</div>";
        }
    } else {
        echo "This user has not uploaded any tracks.";
    }
} else {
    echo "<div class='alert alert-danger'>Could not establish connection.</div>";
}


//VIDEOS DO ARTISTA/DOWNLOAD DE VIDEO
$result = $conn->query("SELECT * FROM media WHERE artist = $id AND song=FALSE");
if ($result) {
    while ($linha = $result->fetch_array(MYSQLI_ASSOC)) {
        echo "<div>";
        $media_id = $linha["id"];
        echo "<div>" . $linha["description"] . "</div>";
        $is_song = $linha["song"];
        if ($linha["rating_n"] / $linha["rating_sum"] != 0) {
            echo "<div>" . $linha["rating_n"] / $linha["rating_sum"] . "</div>";
        }
        download($conn, $media_id, $s3);
        echo "</div>";
    }
} else {
    echo "<div class='alert alert-danger'>Could not establish connection.</div>";
}


function download($conn, $media_id, $s3)
{
    $result = $conn->query("SELECT media,song FROM media WHERE id = $media_id");
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $linha = mysqli_fetch_assoc($result);
            $file_name = $linha["media"];
            $song = $linha["song"];
        } else {
            echo "<div class='alert alert-danger'>Cannot find media. Media might have been deleted.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Could not establish connection.</div>";
    }
    $url = "http://musicprojectofinal.s3.amazonaws.com/" . $file_name;

    echo "<a href='" . $url . "'>Download</a>";
    if ($song == 1) {
        echo "<audio src='" . $url . "' controls>";
        echo "<div class='alert alert-warning fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Your browser does not support the audio element.</div>";
        echo "</audio>";
    } else {
        echo "<video width='320' height='240' controls><source src='" . $url . "'>";
        echo "<div class='alert alert-warning fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Your browser does not support the video tag.</div>";
        echo "</video>";
    }

}


//VIDEOS DO ARTISTA
//EVENTOS COM O ARTISTA
//COMENTARIOS
//DAR RATING
?>
<?php $conn->close(); ?>
</body>
</html>