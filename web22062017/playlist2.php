<?php 
session_start();
include "../inc/dbinfo.inc";
include "../inc/s3info.inc";
if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
}

//include the S3 class              
if (!class_exists('S3')) require_once('S3.php');

//AWS access info
//ALTERAR QUANDO TIVERMOS ACCESS KEY
if (!defined('awsAccessKey')) define('awsAccessKey', S3_PUBLIC_KEY);
if (!defined('awsSecretKey')) define('awsSecretKey', S3_SECRET_KEY);

//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
	<script type="text/javascript" src="//api.html5media.info/1.1.8/html5media.min.js"></script>
	<script type="text/javascript">
	<link rel="stylesheet" type="text/css" href="playlist.css">
	<title>Playlist</title>
</head>

<body>
	<?php include "header.php";?>
	
	<div class="container">

	<?php
	$playlist_id=$_GET["id"];
	$tracks = "";
	$r = $conn->query("SELECT * FROM playlists WHERE id = $playlist_id");
	if($r){
		if (mysqli_num_rows($r)>0){
			$l=mysqli_fetch_assoc($r);
			echo "<div class='column center'><h1>".$l["title"]."</h1>";
			echo "<h6>".$l["description"]."</h6></div>";
echo gettracks($playlist_id,$conn);
//////////////////////////
			echo "
			<script>
			var b = document.documentElement;
			b.setAttribute('data-useragent', navigator.userAgent);
			b.setAttribute('data-platform', navigator.platform);
			jQuery(function ($) {
			var supportsAudio = !!document.createElement('audio').canPlayType;
			if (supportsAudio) {
				var index = 0,
					playing = false,
					mediaPath = 'https://musicprojectofinal.s3.amazonaws.com/', extension = '',tracks = [". gettracks($playlist_id,$conn) . "],
				buildPlaylist = $.each(tracks, function(key, value) {
                var trackNumber = value.track,
                    trackName = value.name;
                if (trackNumber.toString().length === 1) {
                    trackNumber = '0' + trackNumber;
                } else {
                    trackNumber = '' + trackNumber;
                }
                $('#plList').append('" . '<li><div class="plItem"><div class="plNum">' . "' + trackNumber + '.</div><div class=" . '"plTitle"' . ">' + trackName + '</div></div></li>');
            }),
            trackCount = tracks.length,
            npAction = $('#npAction'),
            npTitle = $('#npTitle'),
            audio = $('#audio1').bind('play', function () {
                playing = true;
                npAction.text('Playing');
            }).bind('pause', function () {
                playing = false;
                npAction.text('Paused');
            }).bind('ended', function () {
                npAction.text('Paused');
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    audio.play();
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }).get(0),
            btnPrev = $('#btnPrev').click(function () {
                if ((index - 1) > -1) {
                    index--;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            btnNext = $('#btnNext').click(function () {
                if ((index + 1) < trackCount) {
                    index++;
                    loadTrack(index);
                    if (playing) {
                        audio.play();
                    }
                } else {
                    audio.pause();
                    index = 0;
                    loadTrack(index);
                }
            }),
            li = $('#plList li').click(function () {
                var id = parseInt($(this).index());
                if (id !== index) {
                    playTrack(id);
                }
            }),
            loadTrack = function (id) {
                $('.plSel').removeClass('plSel');
                $('#plList li:eq(' + id + ')').addClass('plSel');
                npTitle.text(tracks[id].name);
                index = id;
                audio.src = mediaPath + tracks[id].file + extension;
            },
            playTrack = function (id) {
                loadTrack(id);
                audio.play();
            };
        extension = audio.canPlayType('audio/mpeg') ? '.mp3' : audio.canPlayType('audio/ogg') ? '.ogg' : '';
        loadTrack(index);
    }
});</script>";
		 }
		else{
			echo "<div class='alert alert-info'>This playlist does not exist.</div>";
		}
	}
	
function gettracks($playlist_id,$conn){
	$tracks="";
	$num = 0;
	$result = $conn->query("SELECT * FROM playlistsongs WHERE playlist_id = $playlist_id");
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
			while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($tracks != "") {$tracks .= ",";}
				$tracks.= gettrack($linha["song_id"],$num,$conn);
				$num+=1;
			}
			return $tracks;
        } else {
            echo "<div class='alert alert-danger'>Cannot find media. Media might have been deleted.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Could not establish connection.</div>";
    }
}


function gettrack($media_id,$num,$conn){
	$result = $conn->query("SELECT * FROM media WHERE id = $media_id");
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
		while($linha = $result->fetch_array(MYSQLI_ASSOC)) {

		$track = "{";
            //$linha = mysqli_fetch_assoc($result);
		$media_artist = $linha["artist"];
		$r = $conn->query("SELECT * FROM artists WHERE artist_id=$media_artist");
            	$l = mysqli_fetch_assoc($r);
			$track.= '"track": '.$num.',';
			$track.= '"name": "'.$l["name"].' - '.$linha["description"].'",';
            		$track.= '"file": "'.$linha["media"].'"}';
			return $track;}
        } else {
            echo "<div class='alert alert-danger'>Cannot find media. Media might have been deleted.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Could not establish connection.</div>";
    }
}
	
?>


    <div class="column add-bottom">
        <div id="mainwrap">
            <div id="nowPlay">
                <span class="left" id="npAction">Paused</span>
                <span class="right" id="npTitle"></span>
            </div>
            <div id="audiowrap">
                <div id="audio0">
                    <audio preload id="audio1" controls="controls">Your browser does not support HTML5 Audio!</audio>
                </div>
                <div id="tracks">
                    <a id="btnPrev">&laquo;</a>
                    <a id="btnNext">&raquo;</a>
                </div>
            </div>
            <div id="plwrap">
                <ul id="plList"></ul>
            </div>
        </div>
    </div>
	
	<div class="column add-bottom center">
        <p>Created by <a href="http://www.markhillard.com/">mh</a>. Music by <a href="http://www.mythium.net/">Mythium</a>.</p>
        <p>Download: <a href="https://archive.org/download/mythium/mythium_vbr_mp3.zip">zip</a> / <a href="https://archive.org/download/mythium/mythium_archive.torrent">torrent</a></p>
    </div>
	
</div>



	
<?php $conn->close();?>
</body>
</html>