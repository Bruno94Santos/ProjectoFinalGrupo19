<?php
session_start();
include "../inc/dbinfo.inc";
if (!isset($_SESSION["loggedin"])) {
    $_SESSION["loggedin"] = 0;
}
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>

<body>
<?php
$id = $_GET["id"];


if (isset($_POST['submit'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $comments = $_POST["comments"];

    try {
        $conn->autocommit(FALSE); // i.e., start transaction

        // assume that the TABLE groups has an auto_increment id field
        $result = $conn->query("SELECT * FROM events WHERE id = $event_id");
        if (!$result) {
            $result->free();
            throw new Exception($conn->error);
        } else {
            $linha = mysqli_fetch_assoc($result);
            if ($linha[sold_out] == False) {
                if ($linha[total_seats] == $linha[seats_taken] + 1) {
                    $soldout = True;
                } else {
                    $soldout = False;
                }
                $seats = $linha[seats_taken] + 1;
                $result1 = $conn->query("UPDATE events SET sold_out = $soldout, seats_taken = $seats WHERE id = $event_id");
                if (!$result1) {
                    $result1->free();
                    throw new Exception($conn->error);
                } else {
                    $result2 = $conn->query("INSERT INTO seats(event_id,buyer) VALUES ($event_id,$id)");
                    if (!$result2) {
                        $result2->free();
                        throw new Exception($conn->error);
                    } else {
                        $code = $id . $seats . date("Hmsdi");
                        echo "Success! Ticket code: " . $id . $seats . date("Hmsdi") . ". Make sure to save this code as it is valid as a receipt.";
                        include "sendmail.php";
                    }
                }
            } else {
                echo "Tickets already sold out.";
            }
        }

        // our SQL queries have been successful. commit them
        // and go back to non-transaction mode.

        $conn->commit();
        $conn->autocommit(TRUE); // i.e., end transaction
    } catch (Exception $e) {

        // before rolling back the transaction, you'd want
        // to make sure that the exception was db-related
        $conn->rollback();
        $conn->autocommit(TRUE); // i.e., end transaction
    }


    /*
    $result = $conn->query("SELECT * FROM events WHERE id = $event_id");
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
    */
}


?>

<!-- validar caracteres nos fields do form para nao haver injeccao de codigo-->
<div class="container">
    <div class="row" style="padding-left: 10%; padding-right: 10%">
        <div class=".col-xs-6 .col-lg-12 col-sx-offset-1">
            <h4 class="page-header">Buying</h4>
            <form method="post" class="buyticket" action="buyticket.php">
                <div class="form-group float-label-control">
                    <label for="">Full name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group float-label-control">
                    <label>Phone</label>
                    <input type="tel" name="phone"> <!--check if input type tel works-->
                </div>
                <div class="form-group float-label-control">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <br>
                <div class="form-group float-label-control">
                    <label>Card type</label><!-- 				VER BOOTSTRAP						-->
                    <select id="pickup_place" name="pickup_place">
                        <option value="" selected="selected">Select One</option>
                        <option value="visa">Visa</option>
                        <option value="mastercard">MasterCard</option>
                        <option value="visaelectron">VisaElectron</option>
                    </select>
                </div>
                <div class="form-group float-label-control">
                    <label>Card number</label>
                    <input type="text" name="pickup_time" required>
                </div>
                <div class="form-group float-label-control">
                    <label>CVV</label>
                    <input type="int" name="dropoff_place">
                </div>
                <div class="form-group float-label-control">
                    <label>Name on card</label>
                    <input type="text" name="customer_name" required>
                </div>
                <div class="form-group float-label-control">
                    <label>Special Instructions</label>
                    <textarea name="comments" maxlength="500"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" name='submit' value="Submit" class="form-log-in-with-existing">
                </div>
            </form>

            <?php $conn->close(); ?>
</body>
</html>
