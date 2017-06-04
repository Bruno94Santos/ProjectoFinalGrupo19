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
    <title>Buy ticket</title>
    <meta name="viewport" content="width=device-width">
    <!--<link rel="stylesheet" href="css/form.css">-->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
            integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
            crossorigin="anonymous"></script>

</head>

<body>
<?php include "header.php"; ?>

<div class="container">
    <div class="row" style="padding-left: 10%; padding-right: 10%">
        <div class=".col-xs-6 .col-lg-12 col-sx-offset-1">

            <?php
            $event_id = $_GET["id"];


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
                                $soldout = 1;
                            } else {
                                $soldout = 0;
                            }
                            $seats = $linha[seats_taken] + 1;
                            $result1 = $conn->query("UPDATE events SET sold_out = $soldout, seats_taken = $seats WHERE id = $event_id");

                            if (!$result1) {
                                $result1->free();
                                throw new Exception($conn->error);
                            } else {
                                $result2 = $conn->query("INSERT INTO seats(event_id,seat) VALUES ($event_id,$seats)");
                                if (!$result2) {
                                    $result2->free();
                                    throw new Exception($conn->error);
                                } else {
                                    $code = $id . $seats . date("Hmsdi");
                                    echo "<div class='alert alert-success fade in'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>Success! Ticket code: " . $event_id . $seats . date("Hmsdi") . ". You will be receiving an email shortly.</div>";
                                    sendEmail($email, $name, $code);
                                    header('Location:event.php?id=' . $event_id); /*<!--Not working?-->*/
                                }
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Tickets already sold out.</div>";
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

            }


            function sendEmail($email, $name, $code)
            {
                $recipient = $email; //recipient
                $email = "projectofinalgrupo19@gmail.com"; //senders e-mail adress

                if ((filter_var($email, FILTER_VALIDATE_EMAIL))) {

                    $Name1 = "Musin Team"; //senders name

                    $mail_body = "Hello " . $name . ", \r\n\n";
                    $mail_body .= "You have just booked a ticket with the following code: " . $code . "\r\n";
                    $mail_body .= "Enjoy the event! \r\n\n";
                    $mail_body .= "Best regards, \r\n";
                    $mail_body .= "Musin Team \r\n";


                    $subject = "Event booking"; //subject
                    $header = "From: " . $Name1 . " <" . $email . ">\r\n"; //optional headerfields

                    mail($recipient, $subject, $mail_body, $header); //mail command :)

                } else {
                    print "<div class='alert alert-danger'>You've entered an invalid email address!</div>";
                }

            }

            ?>

            <!-- validar caracteres nos fields do form para nao haver injeccao de codigo-->
            <h4 class="page-header">Payment details</h4>
            <form method="post" class="buyticket" autocomplete="on" action="buyticket.php?id=<?php echo $event_id; ?>">
                <div class="form-group float-label-control">
                    <label>Full name
                        <input class="form-control" type="text" name="name" maxlength="50" required>
                    </label>
                </div>
                <div class="form-group float-label-control">
                    <label>Phone
                        <input class="form-control" type="tel" name="phone" maxlength="20">
                        <!--check if input type tel works-->
                    </label>
                </div>
                <div class="form-group float-label-control">
                    <label>Email
                        <input class="form-control" type="email" name="email" maxlength="40" required>
                    </label>
                </div>
                <br>
                <div class="form-group float-label-control">
                    <label>Card type<!-- 				VER BOOTSTRAP						-->
                        <select class="form-control" id="pickup_place" name="pickup_place">
                            <option value="" selected="selected">Select One</option>
                            <option value="visa">Visa</option>
                            <option value="mastercard">MasterCard</option>
                            <option value="visaelectron">VisaElectron</option>
                        </select>
                    </label>
                </div>
                <div class="form-group float-label-control">
                    <label>Card number
                        <input class="form-control" type="text" name="pickup_time" maxlength="30" required>
                    </label>
                </div>
                <div class="form-group float-label-control">
                    <label>CVV
                        <input class="form-control" type="int" maxlength="10" name="dropoff_place">
                    </label>
                </div>
                <div class="form-group float-label-control">
                    <label>Name on card
                        <input class="form-control" type="text" maxlength="50" name="customer_name" required>
                    </label>
                </div>
                <div class="form-group float-label-control">
                    <label>Special Instructions
                        <textarea class="form-control" rows="4" name="comments" maxlength="500"></textarea>
                    </label>
                </div>

                <div class="form-group float-label-control">
                    <!--<input type="submit" name='submit' value="Submit">-->
                    <button class="btn btn-default center-block" type="submit" name="submit" value="Submit">Submit
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>


<?php $conn->close(); ?>
</body>
</html>
