<?php 
session_start();
include "../inc/dbinfo.inc";
//include the S3 class              
//if (!class_exists('S3'))require_once('S3.php');

//AWS access info
//ALTERAR QUANDO TIVERMOS ACCESS KEY
//if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIJQEB64PUI4B4MEQ');
//if (!defined('awsSecretKey')) define('awsSecretKey', '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');
 
//instantiate the class
//$s3 = new S3(awsAccessKey, awsSecretKey);

if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
}
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Artist</title>
</head>

<body>
	<?php include "header.php";?>
	<?php
	$id=$_GET["id"];
	$user_id=$_SESSION["id"];
	$result = $conn->query("SELECT * FROM artists WHERE artist_id = $id");
	if($result){
		if (mysqli_num_rows($result)>0){
			$linha = mysqli_fetch_assoc($result);
			$artist_user_id = $linha["id"];
			echo "<div class='jumbotron'>";
				//VER DA CENA DA IMAGEM
				echo "<div class='container'>";
				echo "<div> <img src='" . $linha["picture"] . "'></div>";
				echo "<div>" . $linha["name"] . "</div>";
				echo "<div>" . $linha["location"] . "</div>";
				echo "<div>" . $linha["description"] . "</div>";
				echo "<div>" . $linha["rating_n"] . "</div>";
				echo "<div>" . $linha["rating_sum"] . "</div>";
				echo "<div>" . $linha["rating_n"]/$linha["rating_sum"] . "</div>";
				echo "</div>";
			echo "</div>";
		}
		else{
			echo "There was an error fetching this artist. This page might have been deleted.";
		}
	}
	else{
		echo "Could not establish connection.";
	}
	
	
	//UPLOAD DE MUSICAS
	/*if ($artist_user_id == $user_id){
		echo "<div><a href='upload.php?id=".$artist_user_id."'Upload a new track.</div>";
		//IMPLEMENTAR ISTO
	}*/
	
	
	//MUSICAS DO ARTISTA/DOWNLOAD DE MUSICAS
	$result = $conn->query("SELECT * FROM media WHERE artist = $id");
	if($result){
		while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
			echo "<div>";
				$media_id = $linha["id"];
				echo "<div>" . $linha["description"] . "</div>";
				$is_song = $linha["song"];
				if ($linha["rating_n"]/$linha["rating_sum"] != 0){
					echo "<div>" . $linha["rating_n"]/$linha["rating_sum"] . "</div>";
				}
				$download_page ="download.php?id=".$media_id;
		//	include $download_page;
			echo "</div>";
		}
	}
	else{
		echo "Could not establish connection.";
	}

	
	//VIDEOS DO ARTISTA
	//EVENTOS COM O ARTISTA
	//COMENTARIOS
	//DAR RATING
	?>
<?php $conn->close();?>
</body>
</html>