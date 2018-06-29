<!DOCTYPE html>
<?php
	#TRANSFERED AND COPIED MIGHT SOON BE OBSOLETE
	include "../util_dbHandler.php";
	include("util_check_session.php");
	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

	$stmt = null;
	$stmt = $conn->prepare("SELECT (SELECT COUNT(`id`) FROM `endorsed_exams`) AS `a`, (SELECT COUNT(`id`) FROM `endorsed_exams` WHERE `id` IN (SELECT `Endorsed Id` FROM `exam_schedules`)) AS `b`");
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$endorsed = $sRow[0];
	$scheduled = $sRow[1];
	include("../util_check_stage.php");

	$stmt = null;
	$stmt = $conn->prepare("SELECT COUNT(`id`) FROM `exam_dates`");
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$dCount = $sRow[0];


	$stmt = null;
	$stmt = $conn->prepare("SELECT `Bool Val` FROM `dbconfig` WHERE `Name` = 'Exam Visible'");
	#$stmt->bind_param('i', $_REQUEST['q']);
	$stmt->execute();
	$vResult = $stmt->get_result();
	$vRow = $vResult->fetch_row()[0];
?>
<html>
<head>
	<title>Scheduled Sections</title>
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
	<script type="text/javascript">
		function dropdown(id) {
			var x = document.getElementById("drop-" + id);
			if (x.className.indexOf("w3-show") == -1) {
				x.className += " w3-show";
			}
			else { 
				x.className = x.className.replace(" w3-show", "");
			}
		}
	</script>
	<?php include "fragment_header.php" ?>
	<div id="editSked" class="w3-modal">
		<div class="w3-padding">
			<div style="margin: auto;" class="loader"></div>
		</div>
	</div>
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
					?><p class="w3-card w3-yellow w3-padding"><em>Dates are not yet finished. Please finish it so deans can start endorsing.</em></p><?php
				}
				#-----------------------------------------------------
				if ($stage == 2){
					?><p>Scheduled sections: <?php echo $scheduled; ?> of <?php echo $endorsed; ?></p>
					<button class="w3-button my-blue" style="width: 100%" onclick="flipVisibility()"><?php echo $vRow == '1' ? '<i class="far fa-eye-slash"></i> Hide schedules' : '<i class="fas fa-eye"></i> Show schedules'; ?></button>
					<a href="s_sect/print_friendly_exam_schedules_dean.php<?php if (isset($_REQUEST['id'])) echo "?id=" . $_REQUEST['id']; ?>" target="_blank"><button class="w3-button my-blue" style="width: 100%" type="button">View Printer Friendly (Dean)</button></a>
					<a href="s_sect/print_friendly_exam_schedules_bulletin.php<?php if (isset($_REQUEST['id'])) echo "?id=" . $_REQUEST['id']; ?>" target="_blank"><button class="w3-button my-blue" style="width: 100%" type="button">View Printer Friendly (Bulletin)</button></a>
					<button class="w3-button my-blue" style="width: 100%" onclick="finishExam()">Finish exam</button>
					<script type="text/javascript">
						function finishExam(){
							if (confirm('This action will delete all scueduled sections. And will start over the process of scheduling the examinations from date selection. Contine?')) {
								$.ajax({
									url: "s_sect/ajax_json_finish_exam.php",
									dataType: "json",
									success: function(response){
										//this script returns false regardless
										window.location = '../';
									}
								});
							}
							return false;
						}
						function flipVisibility(){
							$.ajax({
								url: "s_sect/ajax_flip_exam_visibility.php",
								dataType: "json",
								//data: { exDate: $("#inputDate").val() },
								success: function(response){
									//alert(response["result"]);
									location.reload();
									//if(response.sucess){
										
									//}
								}
							});
							return false;
						}
					</script>
					<?php
				}
				else{
					?><p class="w3-card w3-yellow w3-padding"><em><b>INFORMATION:</b> Deans currently can't endorse.</em></p><?php
				}
			?>
		</div>
		
		<div class="w3-rest w3-container">
			<h5>Scheduled Sections</h5>
			<div class="w3-border-bottom w3-border-blue">
				<a class="w3-button subj-tabs <?php if (!isset($_REQUEST['id'])) echo "my-blue"; ?>" href="scheduled_subjects.php" type="button"><i class="fas fa-home" aria-hidden="true"></i></a><?php
					$stmt = null;
					$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('');");
					$stmt->execute();
					$usResult = $stmt->get_result();
					if ($usResult->num_rows > 0) {
						while ($usRow = $usResult->fetch_assoc()) {
							?><a class="w3-button subj-tabs <?php if (isset($_REQUEST['id']) && $_REQUEST['id'] == $usRow['Id']) echo "my-blue"; ?>" href="scheduled_subjects.php?id=<?php echo $usRow['Id']; ?>" type="button"><?php echo "Day " . $usRow['rank']; ?></a><?php
						}
					}
				?>
			</div>
			<?php 
				include "s_sect/fragment_scheduled_subjects.php"; 
			?>		
		</div>
	</div>
	<?php include "fragment_footer.php" ?>
	<script type="text/javascript">
		function showEditSked(id){
			document.getElementById('editSked').style.display='inline';
			$.ajax({
				url: "s_sect/edit_time/ajax_fragment_edit-time.php",
				data: { id: id },
				success: function(response){
					$("#editSked").html(response);
				}
			});
			return false;
		}
		function chkTimeStack(){
			if ($("#tAuto").is(':checked')){
				document.getElementById('rTime').style.display='none';
			}
			else{
				document.getElementById('rTime').style.display='';
			}
		}
	</script>
</body>
</html>