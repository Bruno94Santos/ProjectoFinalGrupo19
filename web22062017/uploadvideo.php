<?php 
session_start();
include "../inc/dbinfo.inc";
include "../inc/s3info.inc";
//include the S3 class              
if (!class_exists('S3'))require_once('S3.php');
if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
}

//AWS access info
//ALTERAR QUANDO TIVERMOS ACCESS KEY
if (!defined('awsAccessKey')) define('awsAccessKey', S3_PUBLIC_KEY);
if (!defined('awsSecretKey')) define('awsSecretKey', S3_SECRET_KEY);
 
//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Upload a new video</title>
</head>

<body>
<?php include "header.php";?>
	<?php
	$id=$_GET["id"];
	$user_id=$_SESSION["id"]; //is_song?
	if(isset($_POST["Submit"])){
    //retrieve post variables
		$fileName = $_FILES['newTrack']['name'];
		$fileTempName = $_FILES['newTrack']['tmp_name'];
		$media = $id . "m" . $user_id . "m" . date('Y0m0d0H0i0s').strstr($fileName,'.');
		$description=$_POST["description"];
		$result = $conn->query("INSERT INTO media(artist,song,description,media,rating_sum,rating_n) VALUES ($id,0,'$description','$media',0,0)");
		if($result && $s3->putObjectFile($fileTempName, "musicprojectofinal", $media, S3::ACL_PUBLIC_READ)){
			echo "<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Uploaded with success!</div>";
			$newLocation = 'artist.php?id=' . $id;
			echo '<meta http-equiv="refresh" content="0; URL='.$newLocation.'">';

		}
		else{
			die("<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Error when uploading.</div>");
		}
	}
	
	?>
	<div class="container">
	<div class="row">
	<div class="col-xs-12">
	<form action="" method="post" enctype="multipart/form-data"> 
		<p>Submit your video below</p>
		<div class="form-group float-label-control">
			<label>Track name</label>
			<input class="form-control" type="text" name="description" required><br>
		</div>
		<div class="form-group float-label-control">
			<label>File</label>
			<input class="form-control" name="newTrack" accept="video/*" type="file" required />
		</div>
		<button class="btn btn-default center-block" type="submit" name="Submit">Upload</button>	
	</form>
	</div>
	</div>
	</div>
	
<?php $conn->close();?>
</body>
</html>