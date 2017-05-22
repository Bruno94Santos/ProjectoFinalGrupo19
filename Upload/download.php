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

//S3::getObject($bucketName, $uploadName, $saveName)
//TEST LATER
$url = $s3->getAuthenticatedURL("music", $file_name, 900));

echo "<a href='$url' target='_blank'>Download</a>";


?>
