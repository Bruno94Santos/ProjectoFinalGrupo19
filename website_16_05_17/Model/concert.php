<?php
 include "../../inc/dbinfo.inc";


 session_start(); //on index top
 if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
 }

 header("Content-Type: application/json; charset=UTF-8");

 $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

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

?>