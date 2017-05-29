<?php
 include "../../inc/dbinfo.inc";


 session_start(); //on index top
 if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
 }

 header("Content-Type: application/json; charset=UTF-8");

 $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

 //all artists
 	function get_all_artists(){
 		$result = $conn->query("SELECT * FROM artists");
 		$output="";
 		if($result){
 			while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
 				if ($output != "") {$output .= ",";}
 				$output .= '{"ArtistUserID":"'  . $linha["id"] . '",';
 				$output .= '"ArtistID":"'  . $linha["artist_id"] . '",';
 				$output .= '"ArtistPicture":"'  . $linha["picture"] . '",';
 				$output .= '"ArtistName":"'  . $linha["name"] . '",';
 				$output .= '"ArtistLocation":"'  . $linha["location"] . '",';
 				$output .= '"ArtistDescription":"'  . $linha["description"] . '",';
 				$output .= '"NumberRatings":"'. $linha["rating_n"] . '",';
 				$output .= '"SumRatings":"'. $linha["rating_sum"] . '",';
 				$output .= '"ArtistRating":"'. $linha["rating_n"]/$linha["rating_sum"] . '"}';
 			}
 			$output ='{"records":['.$output.']}';
 			return $output;
 		}
 		else{
 			echo "Could not establish connection.";
 		}
 	}

?>