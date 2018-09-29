<!DOCTYPE html>
<?php
	#TRANSFERED AND COPIED MIGHT SOON BE OBSOLETE
	include_once "../util_dbHandler.php";
	include_once("util_check_session.php");
?>
<html>
<head>
	<title>Manage exam schedules</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/jquery-ui-timepicker-addon.css">
	<link href="../jquery-ui-1.12.1.custom/jquery-ui.css" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="../css/fontawesome-all.css">
	<style type="text/css">
		/*Mozila recolors the invalid entry upon clearing via javascript. So it is needed*/
		@-moz-document url-prefix(){
			input:required {
				box-shadow:none!important;
			}
			input:invalid {
				box-shadow:0 0 3px red;
			}
		}
		input[type="date"]::-webkit-input-placeholder{ 
			visibility: hidden !important;
		}
	</style>
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<script src="/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="/scripts/jquery-ui-timepicker-addon.js"></script>
	
	<?php include_once "fragment_header.php" ?>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<div class="w3-hide-small">
				<img  src="/images/sys-logo.png" style="width: 100%">
				<br>
				<br>
				<hr>
			</div>
			<?php
				if (isset($_GET["view"])){
					if ($_REQUEST["view"] == 1){
						?>
						<p>This system automatically stacks scheduels starting from <b>2:00 pm</b> with the same room.</p>
						<p>To <b>change</b>, use time override for the section.</p>
						<!--form class="w3-card w3-padding" onsubmit="return false" style="">
							<h5 class="w3-border-bottom w3-border-blue">Room Reservation</h5>
							<input class="my-input-1" type="text" placeholder="Room" name="">
							<input class="my-input-1" type="text" placeholder="Time" name="">
							<button class="my-button my-blue w3-section" type="submit">Apply</button>
						</form><br-->
						<!--button class="w3-button my-blue" style="width: 100%" type="button" onclick="">Rooms</button-->
						<!--button class="w3-button my-blue" style="width: 100%" type="button" onclick="">Batch add wizzard</button-->
						<?php
					}
					elseif ($_REQUEST["view"] == 2){
						?><a href="print_friendly_exam_schedules.php" target="_blank"><button class="w3-button my-blue" style="width: 100%" type="button">View Printer Friendly (All days)</button></a><?php
					}
					elseif ($_REQUEST["view"] == 3){
						#include_once "tbd.php"; 
					}
				}
			?>
		</div>
		
		<div class="w3-rest w3-container">
			<div class="w3-border-bottom w3-border-blue">
				<a href="manage_exam_schedule.php" class="w3-button subj-tabs <?php if(!isset($_REQUEST["view"])) echo 'my-blue'; ?>" type="button"><i class="fas fa-home" aria-hidden="true"></i>
				</a><a href="manage_exam_schedule.php?view=1" class="w3-button subj-tabs <?php if(isset($_REQUEST["view"]) && $_REQUEST["view"] == 1) echo 'my-blue'; ?>" type="button">Unscheduled Subjects
				</a><a href="manage_exam_schedule.php?view=2" class="w3-button subj-tabs <?php if(isset($_REQUEST["view"]) && $_REQUEST["view"] == 2) echo 'my-blue'; ?>" type="button">Scheduled Subjects
				</a><a href="manage_exam_schedule.php?view=3" class="w3-button subj-tabs <?php if(isset($_REQUEST["view"]) && $_REQUEST["view"] == 3) echo 'my-blue'; ?>" type="button">Rooms</a>
			</div>
			<?php 
				if (isset($_REQUEST["view"])){
					if ($_REQUEST["view"] == 1){
						include_once "fragment_unscheduled_subjects.php"; 
					}
					elseif ($_REQUEST["view"] == 2){
						include_once "fragment_scheduled_subjects.php"; 
					}
					elseif ($_REQUEST["view"] == 3){
						include_once "fragment_rooms.php"; 
					}
				}
				else{
					include_once "fragment_manage_schedule_home.php"; 
				}
			?>		
		</div>
	</div>
	<?php include_once "fragment_footer.php" ?>
	<script src="fragment_table_exam_schedules.js">//Contains filler of datalists</script>
</body>
</html>