<!DOCTYPE html>
<?php
	include "../util_dbHandler.php";
	include("util_check_session.php");
	include("../util_greeting.php");
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
	<?php include "fragment_header.php" ?>
	<?php #include "../fragment_changepass_dlg.php" ?>
	<div class="w3-row w3-margin-top">
		<!--div class="my-third w3-container">
		</div-->
		<div class="w3-container" style="">
			<div align="center">
				<img class="w3-hide-small" style="display: block; margin: auto; width: 2.5in;"  src="/images/sys-logo.png">
				<div class="w3-padding w3-margin my-transparent-black-2">
					<h2 style="color: white;"><?php echo $greeting; ?></h2>
				</div>
			</div>
			<br><br><hr>
			<div class="w3-center">
				<?php include "../fragment_changepass_card.php" ; ?>
				<a href="manage_accounts.php" class="w3-card-4 w3-margin home-link" style="overflow: auto; height: 1.5in;">
					<header class="w3-container my-blue">
						<h6 style="">Manage Accounts</h6>
					</header>
					<p class="w3-container">Register users for the system, reset their password, or rename them.</p>
				</a>
				<a href="manage_db.php" class="w3-card-4 w3-margin home-link" style="overflow: auto; height: 1.5in;">
					<header class="w3-container my-blue">
						<h6 style="">Manage Database</h6>
					</header>
					<p class="w3-container">Backup and restore database.</p>
				</a>
			</div>
		</div>
	</div>
	<?php include "fragment_footer.php" ?>
	<script type="text/javascript">
	</script>
</body>
</html>