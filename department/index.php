<!DOCTYPE html>
<?php
	include_once "../util_dbHandler.php";
	include_once("util_check_session.php");
	$stmt = null;
	$stmt = $conn->prepare("SELECT COUNT(`Dean_Id`) FROM `departments` WHERE `Dean_Id` = ?");
	$stmt->bind_param('s',$_SESSION['ID']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$isDeptExist = $sRow[0];
	if($isDeptExist == 0){
		include_once 'init.php';
		exit;
	}

	include_once("../util_check_stage.php");
	include_once("util_check_isEndorsed.php"); #Also carries dept name and accr
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
				<a href="manage_exam_schedule.php" class="w3-card-4 w3-margin home-link" style="overflow: auto; height: 1.5in;">
					<header class="w3-container <?php echo ($isEndorsed || $stage != 2) ? 'my-blue' : 'w3-red'; ?>">
						<h6 style=""><?php echo $isEndorsed ? 'View Endorsed' : 'Endorse Schedules'; ?></h6>
					</header>
					<!--p class="w3-container">Use this to view endorsed sections to SDO for exam schedules.</p-->
					<?php
						if($stage == 2){
							?><p class="w3-container">Endorsement is now open and you are <b><?php echo $isEndorsed ? 'finished' : 'not yet finished'; ?></b>.</p><?php
						}
						else{
							?><p class="w3-container">Endorsement is currently close.</p><?php
						}
					?>
				</a>
				<a href="manage_subjects.php" class="w3-card-4 w3-margin home-link" style="overflow: auto; height: 1.5in;">
					<header class="w3-container my-blue">
						<h6 style="">Manage Courses and Subjects</h6>
					</header>
					<p class="w3-container">Add courses and subjects in it.</p>
				</a>
				<a href="manage_sections.php" class="w3-card-4 w3-margin home-link" style="overflow: auto; height: 1.5in;">
					<header class="w3-container my-blue">
						<h6 style="">Manage Sections</h6>
					</header>
					<p class="w3-container">Open sections and assign professors in it. </p>
				</a>
				<a href="manage_professors.php" class="w3-card-4 w3-margin home-link" style="overflow: auto; height: 1.5in;">
					<header class="w3-container my-blue">
						<h6 style="">Manage Professors</h6>
					</header>
					<p class="w3-container">Register and delete professors accounts.</p>
				</a>
			</div>
			
		</div>
	</div>
	<?php include_once "fragment_footer.php" ?>
	<script type="text/javascript">
	</script>
</body>
</html>