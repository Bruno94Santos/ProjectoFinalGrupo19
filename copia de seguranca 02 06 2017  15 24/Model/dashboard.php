<?php
 session_start(); //on index top
 include "../../inc/dbinfo.inc";

 if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
 }

 header("Content-Type: application/json; charset=UTF-8");

 $data = json_decode(file_get_contents("php://input"));
 $connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
	$output="";
	$output .= '{"Username":"' . $_SESSION["username"] . '",';
	$output .= '"UserID":"' . $_SESSION["id"] . '",';
	$output .= '"UserPicture":"' . $_SESSION["picture"] . '",';
	$output .= '"Email":"' . $_SESSION["email"] . '",';
	$output .= '"IsArtist":"' . $_SESSION["is_artist"] . '",';
	$output .= '"LoggedIn":"' . 1 . '",';
	$output .= '"Admin":"' . 0 . '"}';
	echo $output;

 	function get_media($id){
    		$result = $conn->query("SELECT * FROM media WHERE id = $id");
    		if($result){
    			if (mysqli_num_rows($result)>0){
    				$linha=mysqli_fetch_assoc($result);
    				$output="";
    				$output .= '{"MediaID":"'  . $linha["id"] . '",';
    				$output .= '"ArtistID":"'  . $linha["artist"] . '",';
    				$output .= '"IsSong":"'  . $linha["song"] . '",';
    				$output .= '"Description":"'  . $linha["description"] . '",';
    				$output .= '"Media":"'  . $linha["media"] . '",';
    				$output .= '"NumberRatings":"'. $linha["rating_n"] . '",';
    				$output .= '"SumRatings":"'. $linha["rating_sum"] . '",';
    				$output .= '"MediaRating":"'. $linha["rating_n"]/$linha["rating_sum"] . '"}';
    				return $output;
    			}
    			else{
    				echo "Cannot find media. Media might have been deleted.";
    			}
    		}
    		else{
    			echo "Could not establish connection.";
    		}
    	}
$connection->close();
?>