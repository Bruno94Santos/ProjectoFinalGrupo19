<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
          integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/nav.css">


</head>

<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="home.php" class="navbar-brand">MusIn</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="events.php">Events</a></li>
                <li><a href="artists.php">Artists</a></li>
                <!--<li><a href="playlists.php">Playlists</a></li> TODO-->
            </ul>
            <ul class="nav navbar-nav navbar-right">
		<form action="search.php" method="post">
			<input type="text" name="search" placeholder="Search...">
			<input type="checkbox" name="choice" value="1">artist
			<input type="checkbox" name"choice" value="0">event
			<input type="submit" name="submit" value="Go"> 
		</form> 
                <?php if ($_SESSION["loggedin"] == 0) { ?>
                    <ul class="nav navbar-nav">
                        <li><a href="register.php">Register</a></li>
                        <li><a href="login.php">Login</a></li>
                    </ul>
                <?php } else { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span>
                            <strong>Welcome, <?php echo $_SESSION["username"]; ?></strong>
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="navbar-login">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <p class="text-center">
                                                <span class="glyphicon glyphicon-user icon-size"></span>
                                            </p>
                                        </div>
                                        <div class="col-lg-8">
                                            <p class="text-left"><strong><?php echo $_SESSION["username"]; ?></strong>
                                            </p>
                                            <p class="text-left small"><?php echo $_SESSION["email"]; ?></p>
                                            <p class="text-left">
                                                <!--<a href="profile.html"
                                                   class="btn btn-primary btn-block btn-sm">Profile</a> TODO -->
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="divider navbar-login-session-bg"></li>
                            <!--<li><a href="likes.php">Faves</a></li>
                            <li class="divider"></li> TODO-->
                            <li><a href="myevent.php">My Events</a></li>
                            <li class="divider"></li>
                            <li><a href="userartist.php">My Artist page<!--Your music--></a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>

                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

</body>
</html>