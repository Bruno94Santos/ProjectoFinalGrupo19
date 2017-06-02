<?php
session_start(); //on index top
include "../../dbinfo.inc";

 if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
 }

 header("Content-Type: application/json; charset=UTF-8");

 $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

 function get_artist($artist_id){
		$result =  $connection->query("SELECT * FROM artists WHERE artist_id = $artist_id");
		if($result){
			if (mysqli_num_rows($result)>0){
				$linha=mysqli_fetch_assoc($result);
				$output="";
				$output .= '{"ArtistUserID":"'  . $linha["id"] . '",';
				$output .= '"ArtistID":"'  . $linha["artist_id"] . '",';
				$output .= '"ArtistPicture":"'  . $linha["picture"] . '",';
				$output .= '"ArtistName":"'  . $linha["name"] . '",';
				$output .= '"ArtistLocation":"'  . $linha["location"] . '",';
				$output .= '"ArtistDescription":"'  . $linha["description"] . '",';
				$output .= '"NumberRatings":"'. $linha["rating_n"] . '",';
				$output .= '"SumRatings":"'. $linha["rating_sum"] . '",';
				$output .= '"ArtistRating":"'. $linha["rating_n"]/$linha["rating_sum"] . '"}';
				return $output;
			}
			else{
				echo "There was an error fetching this artist. This page might have been deleted.";
			}
		}
		else{
			echo "Could not establish connection.";
		}
	}


	function get_media_by_artist($id){
    		$result =  $connection ->query("SELECT * FROM media WHERE artist = $id");
    		if($result){
    			while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
                    $output="";
                    if ($output != "") {$output .= ",";}
    				$output .= '{"MediaID":"'  . $linha["id"] . '",';
    				$output .= '"ArtistID":"'  . $linha["artist"] . '",';
    				$output .= '"IsSong":"'  . $linha["song"] . '",';
    				$output .= '"Description":"'  . $linha["description"] . '",';
    				$output .= '"Media":"'  . $linha["media"] . '",';
    				$output .= '"NumberRatings":"'. $linha["rating_n"] . '",';
    				$output .= '"SumRatings":"'. $linha["rating_sum"] . '",';
    				$output .= '"MediaRating":"'. $linha["rating_n"]/$linha["rating_sum"] . '"}';
    				$output ='{"records":['.$output.']}';
    			return $output;
    			}
    			else{
    				return "Cannot find media. Media might have been deleted.";
    			}
    		}
    		else{
    			return "Could not establish connection.";
    		}
    	}
?>
