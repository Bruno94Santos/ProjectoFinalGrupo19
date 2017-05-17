<?php  
 include "../../inc/dbinfo.inc";

 session_start(); //on index top
 if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
 }

header("Content-Type: application/json; charset=UTF-8");

 $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
 
 $database = mysqli_select_db($connection, DB_DATABASE);
	if($_SESSION["loggedin"]==0){
		$result = $connection->query("SELECT * FROM users WHERE username='".$username."' OR email='".$username."' AND PASSWORD='".$password."');

		if($result){
			if (mysqli_num_rows($result)>0){
				$linha=mysqli_fetch_assoc($result);
				session = {'username':$username, "id":$linha['id'], "picture":$linha["picture"], "email":$linha["email"], "is_artist":$linha["is_artist"]};
				$_SESSION["user"]=session;
				/*$_SESSION["username"]=$username;
				$_SESSION["id"]=$linha['id'];
				$_SESSION["picture"]=$linha["picture"];
				$_SESSION["email"]=$linha["email"];
				$_SESSION["bio"]=$linha["bio"];
				$_SESSION["is_artist"]=$linha["is_artist"];
				$_SESSION["loggedin"]=1;
				$_SESSION["admin"]=0;*/
				echo session;
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
