<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
</head>
<body>
	<?php
 		session_start();
		session_unset();
		session_destroy();
		header('Location: home.php');
		exit();
	?>
</body>
</html>