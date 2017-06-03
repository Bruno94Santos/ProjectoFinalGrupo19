<?php 
session_start();
//include the S3 class              
if (!class_exists('S3'))require_once('S3.php');
include "../inc/dbinfo.inc";
if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
}

//AWS access info
//ALTERAR QUANDO TIVERMOS ACCESS KEY
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIJQEB64PUI4B4MEQ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');
 
//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Upload a new track</title>
</head>

<body>
<?php include "header.php";?>
	<?php
	$id=$_GET["id"];
	$user_id=$_SESSION["id"]; //is_song?
	
	if(isset($_POST['Submit'])){
    //retrieve post variables
		//create a new bucket (REMOVER ISTO DEPOIS)
		$s3->putBucket("musicprojectofinal", S3::ACL_PUBLIC_READ);
	
		$fileName = $_FILES['newTrack']['name'];
		$fileTempName = $_FILES['newTrack']['tmp_name'];
		$media = $id . $user_id . date('Y-m-d-H-i-s');
		$result = $conn->query("INSERT INTO media(artist,song,description,media,rating_sum,rating_n) VALUES ($id,TRUE,'$description','$media',0,0)");
		if($result && $s3->putObjectFile($fileTempName, "musicprojectofinal", $media, S3::ACL_PUBLIC_READ)){
			echo "Uploaded with success.";
		}
		else{
			die("Error when uploading.");
		}
	}
	
	?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<form action="upload.php" method="post" enctype="multipart/form-data"> <!--idk what enctype is-->
					<p>Submit your track below:</p>
					<label>
						<spam>Track name:</spam>
						<input type="text" name="description" required>
					</label>
					<label>
						<spam>File:</spam>
						<input name="newTrack" type="file" accept="audio/*" required />
						<input name="Submit" type="submit" value="Upload">
					</label>
				</form>
			</div>
		</div>
	</div>
<?php $conn->close();?>
</body>
</html>
