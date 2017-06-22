<?php
 include "../../inc/dbinfo.inc";


 session_start(); //on index top
 if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
 }

 header("Content-Type: application/json; charset=UTF-8");

 $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

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

    $msg = "Name: $_POST["name"] \n Surname: $surname \n Phone number: $phone \n Email: $email \n Adress: $adress";
    $to = "$email"
    $subject = "Purchase Confirmarion"
    $headers = "From: <musein@example.com>"

    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);

    // send email
    mail( $to, $subject, $headers, $msg);


	 $connection->close();

     ?>