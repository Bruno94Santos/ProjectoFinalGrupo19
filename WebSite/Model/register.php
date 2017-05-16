<?php  
 include "../../inc/dbinfo.inc";
 //insert.php  
 $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
 
 $database = mysqli_select_db($connection, DB_DATABASE);

 $data = json_decode(file_get_contents("php://input"));  
 if(count($data) > 0)  
 {  
 	$username = mysqli_real_escape_string($connection, $data->username);
	$email = mysqli_real_escape_string($connection, $data->email);       
	$password = mysqli_real_escape_string($connection, $data->password); 
	$query = "INSERT INTO users(username, email, password) VALUES ('$username', '$email', '$password')";
	if(mysqli_query($connection, $query))  
	{  
           echo "Data Inserted...";  
	}  
	else  
	{  
           echo 'Error';  
	}  
 }  
$connection->close();

 ?>  
