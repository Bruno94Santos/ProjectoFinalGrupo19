<?php
//include the S3 class              
if (!class_exists('S3'))require_once('S3.php');
session_start();
include "../../inc/dbinfo.inc";
//VERIFICAR SE ORDEM DISTO ESTA CORRECTA
 
//AWS access info
//ALTERAR QUANDO TIVERMOS ACCESS KEY
if (!defined('awsAccessKey')) define('awsAccessKey', 'CHANGETHIS');
if (!defined('awsSecretKey')) define('awsSecretKey', 'CHANGETHISTOO');
 
//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);
 
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 
function media_upload($is_song,$media,$artist_id){
	$description = "";
	$result = $conn->query("INSERT INTO media(artist,song,description,media,rating_sum,rating_n) VALUES ($artist_id,TRUE,'$description','$media',0,0)");
	if(!$result){
		die("Error when uploading.");
	}
	else{
		echo "Uploaded with success.";
	}
}

//ALTERAR NOME DO FICHEIRO
//CHAMAR FUNÇAO NO CODIGO (primeiro poe-se na bd ou no s3?)
 
 
//check whether a form was submitted
if(isset($_POST['Submit'])){
 
    //retrieve post variables
    $fileName = $_FILES['song']['name'];
    $fileTempName = $_FILES['song']['tmp_name'];
     
    //we'll continue our script from here in the next step!
	//create a new bucket
	//$s3->putBucket("music", S3::ACL_PUBLIC_READ);<br /><br />
	
	//NOME DO BUCKET DA S3 TEM DE SER "music" E DEFINIDO COMO PUBLIC READ
	//move the file
	if ($s3->putObjectFile($fileTempName, "music", $fileName, S3::ACL_PUBLIC_READ)) {
		echo "We successfully uploaded your file.";
	}
	else{
		echo "Something went wrong while uploading your file.";
	}
}

//ALTERAR FORM PARA RECEBER QUAL ARTISTA E QUE ESTA A FAZER UPLOAD
?>

<form action="" method="post" enctype="multipart/form-data">
  <input name="song" type="file" />
  <input name="Submit" type="submit" value="Upload">
</form>
