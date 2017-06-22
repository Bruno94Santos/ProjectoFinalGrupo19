<?php
	session_start(); //on index top
	if(!isset($_SESSION["loggedin"])){
		$_SESSION["loggedin"]=0;
	}
	
	header("Content-Type: application/json; charset=UTF-8");

	$conn = new mysqli("localhost", "root", "projectopgp2017", "projecto_pgp");

	// login
	
	if($_SESSION["loggedin"]==0){
		$result = $conn->query("SELECT * FROM users WHERE username='$username' OR email='$username' AND PASSWORD='$password'");

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
	
	
	//register
	if($_SESSION["loggedin"]==0){
		$result = $conn->query("INSERT INTO users(username,email,password,picture,bio,is_artist) VALUES ('$username','$email','$password','$picture','$bio',FALSE)");
		if(!$result){
			die("Error when registering.");
		}
		else{
			echo "Registered successfully, please login to validate.";
		}
	}
	else{
		echo "Cannot register while logged in.";
	}

	
	//create artist
	
	if($_SESSION["loggedin"]==1){
		$user_id=$_SESSION["id"];
		$result = $conn->query("INSERT INTO artists(id,description,picture,location,name,rating_sum,rating_n) VALUES ($user_id,'$description','$picture','$location','$name',0,0)");
		$res = $conn->query("UPDATE users SET is_artist=TRUE WHERE id = $user_id");
		if(!$result || !$res){
			die("Error when creating artist.");
		}
		else{
			echo "Created artist with success.";
		}
	}
	

	//get single artist
	function get_artist($artist_id){
		$result = $conn->query("SELECT * FROM artists WHERE artist_id = $artist_id");
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
	
	function get_artists_by_page($page){
		$result = $conn->query("SELECT * FROM artists LIMIT $page,3");
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

	//get artist tags
	function artist_tags($artist_id){
		$tags=array();
		$result = $conn->query("SELECT * FROM atags where id=$artist_id");
		if($result){
			while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
				$tags[] = $linha["tag"];
			}
			return $tags;
		}
		else{
			echo "No tags to show";
		}
	}
	
	//get playlist tags
	function playlist_tags($playlist_id){
		$tags=array();
		$result = $conn->query("SELECT * FROM ptags where id=$playlist_id");
		if($result){
			while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
				$tags[] = $linha["tag"];
			}
			return $tags;
		}
		else{
			echo "No tags to show";
		}
	}
	
	//get event tags
	function event_tags($event_id){
		$tags=array();
		$result = $conn->query("SELECT * FROM etags where id=$event_id");
		if($result){
			while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
				$tags[] = $linha["tag"];
			}
			return $tags;
		}
		else{
			echo "No tags to show";
		}
	}
	
	//set tags, TYPE MUST BE atags, ptags, or etags according to if the tags are for artist, playlist, or event
	function set_tag($tag,$id,$type){
		$result = $conn->query("INSERT INTO $type(id,tag) VALUES $id,$tag");
		if(!$result){
			echo "Problem inserting tags.";
		}
	}
	
	
	//create event
	if($_SESSION["loggedin"]==1){
		$user_id=$_SESSION["id"];
		$result = $conn->query("INSERT INTO events(creator_id,picture,event_name,event_time,location,description, total_seats,seats_taken,price,sold_out,rating_sum,rating_n,is_jam) VALUES ($user_id,'$picture','$event_name','$event_time','$location','$description',$total_seats,0,$price,FALSE,0,0,$is_jam)");
		if(!$result){
			die("Error when creating event.");
		}
		else{
			echo "Created event with success.";
		}
	}
	else{
		echo "You must be logged in to create an event.";
	}

	
	//get single event
	function get_event($event_id){
		$result = $conn->query("SELECT * FROM events WHERE id = $event_id");
		if($result){
			if (mysqli_num_rows($result)>0){
				$linha=mysqli_fetch_assoc($result);
				$output="";
				$output .= '{"EventID":"'  . $linha["id"] . '",';
				$output .= '"EventName":"'  . $linha["event_name"] . '",';
				$output .= '"EventTime":"'  . $linha["event_time"] . '",';
				$output .= '"SoldOut":"'  . $linha["sold_out"] . '",';
				$output .= '"JamSession":"'  . $linha["is_jam"] . '",';
				$output .= '"EventLocation":"'  . $linha["location"] . '",';
				$output .= '"EventDescription":"'  . $linha["description"] . '",';
				$output .= '"TotalSeats":"'  . $linha["total_seats"] . '",';
				$output .= '"SeatsTaken":"'  . $linha["seats_taken"] . '",';
				$output .= '"TicketPrice":"'  . $linha["price"] . '",';
				$output .= '"NumberRatings":"'. $linha["rating_n"] . '",';
				$output .= '"SumRatings":"'. $linha["rating_sum"] . '",';
				$output .= '"EventRating":"'. $linha["rating_n"]/$linha["rating_sum"] . '"}';
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
	
	//get all events
	function get_all_events(){
		$result = $conn->query("SELECT * FROM events");
		$output="";
		if($result){
			while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($output != "") {$output .= ",";}
				$output .= '{"EventID":"'  . $linha["id"] . '",';
				$output .= '"EventName":"'  . $linha["event_name"] . '",';
				$output .= '"EventTime":"'  . $linha["event_time"] . '",';
				$output .= '"SoldOut":"'  . $linha["sold_out"] . '",';
				$output .= '"JamSession":"'  . $linha["is_jam"] . '",';
				$output .= '"EventLocation":"'  . $linha["location"] . '",';
				$output .= '"EventDescription":"'  . $linha["description"] . '",';
				$output .= '"TotalSeats":"'  . $linha["total_seats"] . '",';
				$output .= '"SeatsTaken":"'  . $linha["seats_taken"] . '",';
				$output .= '"TicketPrice":"'  . $linha["price"] . '",';
				$output .= '"NumberRatings":"'. $linha["rating_n"] . '",';
				$output .= '"SumRatings":"'. $linha["rating_sum"] . '",';
				$output .= '"EventRating":"'. $linha["rating_n"]/$linha["rating_sum"] . '"}';
			}
			$output ='{"records":['.$output.']}';
			return $output;
		}
		else{
			echo "Could not establish connection.";
		}
	}


	function get_events_by_page($page){
		$result = $conn->query("SELECT * FROM events LIMIT $page,3");
		$output="";
		if($result){
			while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($output != "") {$output .= ",";}
				$output .= '{"EventID":"'  . $linha["id"] . '",';
				$output .= '"EventName":"'  . $linha["event_name"] . '",';
				$output .= '"EventTime":"'  . $linha["event_time"] . '",';
				$output .= '"SoldOut":"'  . $linha["sold_out"] . '",';
				$output .= '"JamSession":"'  . $linha["is_jam"] . '",';
				$output .= '"EventLocation":"'  . $linha["location"] . '",';
				$output .= '"EventDescription":"'  . $linha["description"] . '",';
				$output .= '"TotalSeats":"'  . $linha["total_seats"] . '",';
				$output .= '"SeatsTaken":"'  . $linha["seats_taken"] . '",';
				$output .= '"TicketPrice":"'  . $linha["price"] . '",';
				$output .= '"NumberRatings":"'. $linha["rating_n"] . '",';
				$output .= '"SumRatings":"'. $linha["rating_sum"] . '",';
				$output .= '"EventRating":"'. $linha["rating_n"]/$linha["rating_sum"] . '"}';
			}
			$output ='{"records":['.$output.']}';
			return $output;
		}
		else{
			echo "Could not establish connection.";
		}
	}

	//type must be artists, playlists, or events
	//CHECK IF WORKS
	function get_number($type){
		//$result = $conn->query("SELECT Count(*) AS row_number FROM $type;");
		$query = mysqli_query("SELECT Count(*) AS row_number FROM $type;");
		$result = mysqli_result($query, 0, 0);
		if($result){
			return $result;
		}
		/*if(!$result){
			echo "Could not connect.";
		}
		else{
			$result->fetch_row()[0];
			return $result;
			//return mysql_result($result,0);
		}*/
		
	}
	

	//media upload and download MUST BE DISCUSSED (3rd party? on database?)
	//is_song MUST BE boolean
	function media_upload($is_song,$media,$artist_id){
		$result = $conn->query("INSERT INTO media(artist,song,description,media,rating_sum,rating_n) VALUES ($artist_id,$is_song,'$description','$media',0,0)");
		if(!$result){
			die("Error when uploading.");
		}
		else{
			echo "Uploaded with success.";
		}
	}

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
	

	function get_media_by_artist($id){
		$result = $conn->query("SELECT * FROM media WHERE artist = $id");
		if($result){
			while($linha = $result->fetch_array(MYSQLI_ASSOC)) {
				if ($output != "") {$output .= ",";}
				$output="";
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
				echo "Cannot find media. Media might have been deleted.";
			}
		}
		else{
			echo "Could not establish connection.";
		}
	}
	
	
	//create playlist
	//get playlist
	//get all playlists
	//get x by tag
	//get favourites
	//see followers
	//see following
	//get inbox
	//send message
	//post comment
	//post rating

	
	//get event participants
	//add event participant (if jam only?)
	//remove event participant

	//buy tickets
//fazer isto seguro - INSERIR LOCK
	function buy_ticket($id,$event_id){
		$result = $conn->query("SELECT sold_out, total_seats, seats_taken FROM events WHERE id = $event_id");
		if($result){
			$linha=mysqli_fetch_assoc($result);
			if ($linha[sold_out] == False){
				if($linha[total_seats] == $linha[seats_taken]+1){
					$soldout = True;
				}
				else{
					$soldout = False;
				}
				$seats = $linha[seats_taken]+1;
				$result1 = $conn->query("UPDATE events SET sold_out = $soldout, seats_taken = $seats WHERE id = $event_id");
				if($result1){
					$result2 = $conn->query("INSERT INTO seats(event_id,buyer) VALUES ($event_id,$id)");
					if($result2){
						echo "Ticket bought with success.";
					}
				}
			}
			else{
				echo "Tickets already sold out.";
			}
		}
		else{
			echo "Could not establish connection.";
		}
	}



	
	
	//hall of fame 
	//hall of fame voting
	//blocked users
	
	
	
	$conn->close();
?>
