<?php
 session_start();
 include "../../inc/dbinfo.inc";
 
 if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
 }
  
 $connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 
 $data = json_decode(file_get_contents("php://input"));  
 if($_SESSION["loggedin"] == 0){ 
 	if(count($data) > 0){  
 		$username = mysqli_real_escape_string($connection, $data->username);
		$email = mysqli_real_escape_string($connection, $data->email);       
		$password = mysqli_real_escape_string($connection, $data->password); 
		$query = "INSERT INTO users(username, email, password,is_artist) VALUES ('$username', '$email', '$password','false')";
		if(mysqli_query($connection, $query)){  
           		echo "Data Inserted...";  
		}else{  
           		echo 'Error';  
		}  
 	}
 }else{
	echo "Cannot register while logged in.";
 }

 $connection->close();

 ?>  
