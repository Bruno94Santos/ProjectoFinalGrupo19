<?php  
 session_start(); //on index top

 include "../../inc/dbinfo.inc";
 if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
 }
	
 //header("Content-Type: application/json; charset=UTF-8");

 $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
 
	if($_SESSION["loggedin"]==0){
		$result = $conn->query("SELECT * FROM users WHERE username='$username' OR email='$username' AND PASSWORD='$password'");
		//$result = $conn->query("SELECT * FROM users WHERE username='dzfxv' OR email='$username' AND PASSWORD='sh'");


		if($result){
			if (mysqli_num_rows($result)>0){
				$linha=mysqli_fetch_assoc($result);
				$_SESSION["username"]=$username;
				$_SESSION["id"]=$linha['id'];
				$_SESSION["picture"]=$linha["picture"];
				$_SESSION["email"]=$linha["email"];
				$_SESSION["bio"]=$linha["bio"];
				$_SESSION["is_artist"]=$linha["is_artist"];
				$_SESSION["loggedin"]=1;
				$_SESSION["admin"]=0;
				echo $_SESSION["id"];
				echo $username;
			}
			else{
				echo "Username/email does not exist.";
			}
		}
		else{
			echo "Could not establish connection.";
		}
	}
	else{
		echo "Valid session already active.";
	}
 ?>  
