<html>
	<head>
		<meta charset="UTF-8">
		<script src="http://code.jquery.com/jquery.js"></script>
		<script>
			$(document).ready(function(){
				$('#search').keyup(function(){
					var name = $(this).val();
					$.post('hi.php', {name:name}, function(data){
						$('div#back_result').html(data);
					});
				});
			});
		</script>
	</head>
	<body>
		<form method="post" action="#">
			<input type="text" name="search" placeholder="SEARCH">
		</form>
		<div id="back_result"></div>
	</body>
</html>