<!DOCTYPE html>
<?php
	include "../util_dbHandler.php";
	include("util_check_session.php");
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
	<?php include "fragment_header.php" ?>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<img class="w3-hide-small" src="/images/sys-logo.png" style="width: 100%">
			<br><br><hr>
			<button class="w3-button my-blue" style="width: 100%;" onclick="showPopup('popup_register_student.php')" type="button">Register a student</button>
			<button class="w3-button my-blue" style="width: 100%;" onclick="showPopup('popup_register_guardian.php')" type="button">Register a parent/guardian</button>
			<button class="w3-button my-blue" style="width: 100%;" onclick="showPopup('popup_register_professor.php')" type="button">Register a professor</button>
			<button class="w3-button my-blue" style="width: 100%;" onclick="showPopup('popup_register_department_faculty.php')" type="button">Register a department faculty</button>
			<button class="w3-button my-blue" style="width: 100%;" onclick="showPopup('popup_register_admin.php')" type="button">Register an administrator</button>
			<em class="w3-tiny">Please register the student first before their parent.</em><br>
			<em class="w3-tiny">The default password for every user is abcd1234</em><br>
		</div>
		<div class="w3-rest w3-container" style="min-height: 7in;">
			<?php include "fragment_registered_accounts.php" ?>
		</div>
	</div>
	<?php include "fragment_footer.php" ?>
	<script type="text/javascript">
		function showPopup(dir, name){
			//second parameter helps prevents duplication of window
			openwindow = window.open(dir, name, "toolbar=no, location=yes, scrollbars=yes, resizable=yes, width=600, height=700");
			openwindow.focus();
		}
	</script>
</body>
</html>