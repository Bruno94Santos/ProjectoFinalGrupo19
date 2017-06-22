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
        <div class=".col-xs-6 .col-lg-12">

            <?php
            $event_id = $_GET["id"];


            if (isset($_POST['submit'])) {
                $name = htmlspecialchars($_POST["name"]);
                $email = htmlspecialchars($_POST["email"]);
                $comments = htmlspecialchars($_POST["comments"]);

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
                                    //header("Location:event.php?id=".$event_id);
                                    echo '<meta http-equiv="refresh" content="0; URL=event.php?id=' . $event_id . '">';

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

            <div class="row">
                <!-- CREDIT CARD FORM STARTS HERE -->
                <div class="panel panel-default credit-card-box">
                    <div class="panel-heading display-table">
                        <div class="row display-tr">
                            <h3 class="panel-title display-td">Payment Details</h3>
                            <div class="display-td">
                                <img class="img-responsive pull-right"
                                     src="http://i76.imgup.net/accepted_c22e0.png">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form role="form" class="buyticket" id="payment-form" method="POST"
                              action="buyticket.php?id=<?php echo $event_id; ?>">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="">NAME</label>
                                        <input type="text" class="form-control" name="name" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="">PHONE</label>
                                        <input type="tel" class="form-control" name="phone" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="">EMAIL</label>
                                        <input type="email" class="form-control" name="email" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label for="cardNumber">CARD NUMBER</label>
                                        <div class="input-group">
                                            <input
                                                    type="tel"
                                                    class="form-control"
                                                    name="cardNumber"
                                                    placeholder="Valid Card Number"
                                                    autocomplete="cc-number"
                                                    required autofocus
                                            />
                                            <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-7 col-md-7">
                                    <div class="form-group">
                                        <label for="cardExpiry"><span class="hidden-xs">EXPIRATION</span><span
                                                    class="visible-xs-inline">EXP</span> DATE</label>
                                        <input
                                                type="tel"
                                                class="form-control"
                                                name="cardExpiry"
                                                placeholder="MM / YY"
                                                autocomplete="cc-exp"
                                                required
                                        />
                                    </div>
                                </div>
                                <div class="col-xs-5 col-md-5 pull-right">
                                    <div class="form-group">
                                        <label for="cardCVC">CV CODE</label>
                                        <input
                                                type="tel"
                                                class="form-control"
                                                name="cardCVC"
                                                placeholder="CVC"
                                                autocomplete="cc-csc"
                                                required
                                        />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="subscribe btn btn-success btn-lg btn-block" type="submit"
                                            name="submit" value="Submit">
                                        Buy Ticket
                                    </button>
                                </div>
                            </div>
                            <div class="row" style="display:none;">
                                <div class="col-xs-12">
                                    <p class="payment-errors"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- CREDIT CARD FORM ENDS HERE -->

            </div>
            <?php $conn->close(); ?>
</body>
</html>