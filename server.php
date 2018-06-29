<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<ul>
		<?php
			foreach ($_SERVER as $key => $value) {
				echo "<li>" . $key . ":" . $value . "</li>";
			}
		?>
	</ul>
</body>
</html>
