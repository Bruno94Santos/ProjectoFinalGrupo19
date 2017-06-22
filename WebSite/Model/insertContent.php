<?php
 include "../../inc/dbinfo.inc";


 session_start(); //on index top
 if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
 }

 header("Content-Type: application/json; charset=UTF-8");

 $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);


 function media_upload($is_song,$media,$artist_id, $description){
 		$result = $conn->query("INSERT INTO media(artist,song,description,media,rating_sum,rating_n) VALUES ($artist_id,$is_song,'$description','$media',0,0)");
 		if(!$result){
 			die("Error when uploading.");
 		}
 		else{
 			echo "Uploaded with success.";
 		}
 	}


 $connection->close();

 ?>