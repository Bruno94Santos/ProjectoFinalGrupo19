<?php
//$id=$_GET["id"];

$result = $conn->query("SELECT media FROM media WHERE id = $media_id");
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $file_name = $linha["media"];
    } else {
        echo "Cannot find media. Media might have been deleted.";
    }
} else {
    echo "Could not establish connection.";
}

//S3::getObject($bucketName, $uploadName, $saveName)
//TEST LATER
//???????
$url = s3->getObject("musicprojectofinal", $file_name, 900)
//??????
//$url = $s3->getAuthenticatedURL("musicprojectofinal", $file_name, 900));
//$s3->getAuthenticatedURL("musicprojectofinal", $file_name, fopen('php://output', 'wb'));
//$url = "http://musicprojectofinal.s3.amazonaws.com/".$file_name;
echo "<a href='" . $url . "' target='_blank'>Download</a>";



/* $file = "http://musicprojectofinal.s3.amazonaws.com/".$file_name;

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
} */
?>

<audio src="<?php echo $url; ?>" controls>
    Your browser does not support the audio element.
</audio> 