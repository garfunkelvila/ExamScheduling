<!DOCTYPE html>
<?php
	include_once "../util_dbHandler.php";
	include_once("util_check_session.php");
?>

<html>
<head>
	<title>Home</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
	<style type="text/css">
		body{
			background-image: url('/images/bg3.jpg');
			background-attachment: fixed!important;
			
			background-repeat: no-repeat;
			background-size: cover;
		}

		@media (max-width:600px){
			.giant-icon{
				font-size: 15em;
			}
		}

		@media (max-width:992px) and (min-width:601px){
			.giant-icon{
				font-size: 5em;
			}
		}

		@media (min-width:993px){
			.giant-icon{
				font-size: 10em;
			}
		}
		.my-hover-text-blue:hover{color:#0024f4!important}
	</style>
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<?php include_once "fragment_header.php" ?>
	<div class="w3-row w3-margin-top">
		<!--div class="my-third w3-container">
		</div-->
		<div class="w3-container" style="color: white;">
			<div>
				<img style="display: block; margin: auto; width: 2.5in;" align="center" src="/images/sys-logo.png">
			</div>
			<br><br><hr>
			<?php include_once "../fragment_changepass_dlg.php" ?>
			<div class="w3-third w3-padding" style="text-align: center;">
				<div class="w3-padding w3-card my-opacity-black">
					<a href="manage_accounts.php" class="my-hover-text-blue"><i class="fas fa-id-card-o giant-icon" aria-hidden="true"></i></a>
					<a href="manage_accounts.php" class="my-hover-text-blue"><h1>Manage Accounts</h1></a>
					Register, rename and delete accounts.
				</div>
			</div>
			<div class="w3-third w3-padding" style="text-align: center;">
				<div class="w3-padding w3-card my-opacity-black">
					<a href="manage_class_list.php" class="my-hover-text-blue"><i class="fas fa-list-alt giant-icon" aria-hidden="true"></i></a>
					<a href="manage_accounts.php" class="my-hover-text-blue"><h1>Manage Class List</h1></a>
					Manage department list, course list, subject, and class list.
				</div>
			</div>
			<div class="w3-third w3-padding" style="text-align: center;">
				<div class="w3-padding w3-card my-opacity-black">
					<a href="manage_exam_schedule.php" class="my-hover-text-blue"><i class="fas fa-calendar giant-icon" aria-hidden="true"></i></a>
					<a href="manage_accounts.php" class="my-hover-text-blue"><h1>Manage Exam Schedules</h1></a>
					Create exam schedules for examination. Assign proctors on each rooms.
				</div>
			</div>
		</div>
	</div>
	<?php include_once "fragment_footer.php" ?>
	<script type="text/javascript">
	</script>
</body>
</html>