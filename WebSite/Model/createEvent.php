<?php
 include "../../inc/dbinfo.inc";


 session_start(); //on index top
 if(!isset($_SESSION["loggedin"])){
	$_SESSION["loggedin"]=0;
 }

 header("Content-Type: application/json; charset=UTF-8");

 $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

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

        function set_tag($tag,$id,$type){
        		$result = $conn->query("INSERT INTO $type(id,tag) VALUES $id,$tag");
        		if(!$result){
        			echo "Problem inserting tags.";
        		}
        	}

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

 $connection->close();

  ?>