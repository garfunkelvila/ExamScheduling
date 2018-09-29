<!DOCTYPE html>
<?php
	include_once "../util_dbHandler.php";
	include_once("util_check_session.php");
	include_once("../util_greeting.php");
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
	<?php #include_once "../fragment_changepass_dlg.php" ?>
	<div class="w3-row w3-margin-top">
		<div class="w3-container" style="">
			<div align="center">
				<img class="w3-hide-small" style="display: block; margin: auto; width: 2.5in;" src="/images/sys-logo.png">
				<div class="w3-padding w3-margin my-transparent-black-2">
					<h2 style="color: white;"><?php echo $greeting; ?></h2>
				</div>
			</div>
			<br><br><hr>
			<div class="w3-center">
				<?php include_once "../fragment_changepass_card.php" ; ?>
				<a href="exam_dates.php" class="w3-card-4 w3-margin home-link" style="overflow: auto; height: 1.5in;">
					<header class="w3-container my-blue">
						<h6 style="">Manage Exam Dates</h6>
					</header>
					<p class="w3-container">Add, edit or delete exam dates. Here you can also allow deans to start endorsing.</p>
				</a>
				<a href="unscheduled_subjects.php" class="w3-card-4 w3-margin home-link" style="overflow: auto; height: 1.5in;">
					<header class="w3-container my-blue">
						<h6 style="">Manage Unscheduled Sections</h6>
					</header>
					<p class="w3-container">Here you can see the deans endorsed sections, finished or not. This list wont show sections that are already scheduled.</p>
				</a>
				<a href="scheduled_subjects.php" class="w3-card-4 w3-margin home-link" style="overflow: auto; height: 1.5in;">
					<header class="w3-container my-blue">
						<h6 style="">Manage Scheduled Sections</h6>
					</header>
					<p class="w3-container">List of sections already scheduled, printing of schedules and finising exam.</p>
				</a>
			</div>
		</div>
	</div>
	<?php include_once "fragment_footer.php" ?>
	<script type="text/javascript">
	</script>
</body>
</html>