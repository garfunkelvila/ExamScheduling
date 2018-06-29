<?php
	#TRANSFERED AND COPIED MIGHT SOON BE OBSOLETE
	include "../util_dbHandler.php";
	include("util_check_session.php");
	include("../util_check_stage.php");

	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

	$stmt = null;
	$stmt = $conn->prepare("SELECT COUNT(`id`) FROM `exam_dates`");
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$dCount = $sRow[0];

?><!DOCTYPE html>
<html>
<head>
	<title>Unscheduled Sections</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/jquery-ui-timepicker-addon.css">
	<link rel="stylesheet" href="../jquery-ui-1.12.1.custom/jquery-ui.css" type="text/css"/>
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
	
	<?php include "fragment_header.php" ?>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<div class="w3-hide-small">
				<img  src="/images/sys-logo.png" style="width: 100%">
				<br>
				<br>
				<hr>
			</div>
			<?php 
				if ($stage == 1 && $dCount > 0){
					?><p class="w3-card w3-yellow w3-padding"><em>Dates are not yet finished. Please finish it.</em></p><?php
				}
			?>
			<ul class="w3-ul w3-card w3-padding"><?php 
				$stmt = null;
				$stmt = $conn->prepare("CALL `select_departments`('');");
				$stmt->execute();
				$udResult = $stmt->get_result();
				if ($udResult->num_rows > 0) {
					while ($udRow = $udResult->fetch_assoc()) {
						?><li><i class="fas <?php echo $udRow['isEndorsed']==1 ? 'fa-check' : 'fa-times'; ?>"></i> <?php echo '<b>' . $udRow['Acronym'] . '</b> : ' . $udRow['FullName']; ?></li><?php
					}
				}
				else{
					?><li><i class="fas fa-times w3-text-red"></i> No department registered on the system.</li><?php
				}
			?>
			</ul>
			<p><em>This system automatically stacks scheduels starting from <b>2:00 pm</b> to <b>7:30 pm</b> with the same room.</em></p>
			<p><em>To <b>change</b>, use time override for the section.</em></p>
			<p><em>The day shown every row is just the deans sudgested day.</em></p>
		</div>
		<div class="w3-rest w3-container">
			<h5>Unscheduled Sections</h5>
			<?php 
				include "e_sect/fragment_unscheduled_subjects.php"; 
			?>		
		</div>
	</div>
	<?php include "fragment_footer.php" ?>
</body>
</html>