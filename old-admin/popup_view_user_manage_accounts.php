<?php
	include_once "../util_dbHandler.php";
?>
<html>
<head>
	<title>Manage accounts</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<div class="w3-container" style="max-width: 5in;">
	<?php
		$name = "";

		$stmt = null;
		$stmt = $conn->prepare("SELECT `Access Id`, CONCAT(`users`.`First Name`, ' ', `users`.`Family Name`) FROM `users` WHERE `Id Number` = ?");
		$stmt->bind_param('s', $_REQUEST['idNum']);
		$stmt->execute();
		$row = $stmt->get_result()->fetch_row();
		$accResult = $row[0];
		$name = $row[1];
		switch ($accResult) {
			case '3':
				include_once "fragment_table_popup_student_subjects.php";
				break;
			case '4':
				include_once "fragment_table_popup_guardian_monitor.php";
				break;
			default:
				echo "Only supports student and parents";
				break;
		}
	?>
	</div>
</body>
</html>