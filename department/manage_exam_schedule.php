<?php
	include "../util_dbHandler.php";
	include("util_check_session.php");
	include("../util_check_stage.php");
	include("util_check_isEndorsed.php");


	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);



	$stmt = null;
	$stmt = $conn->prepare("SELECT `Int Val` FROM `dbconfig` WHERE `Name` = 'Exam Period'");
	$stmt->execute();
	$perResult = $stmt->get_result();
	$perRow = $perResult->fetch_row();

	switch ($perRow[0]) {
		case '1':
			$per = "Prelim";
			break;
		case '2':
			$per = "Midterm";
			break;

		case '3':
			$per = "Finals";
			break;
		default:
			$per = "Err";
			break;
	}
	
	$stmt = null;
	$stmt = $conn->prepare("SELECT calc_SY()");
	#$stmt->bind_param('i', $_REQUEST['q']);
	$stmt->execute();
	$syResult = $stmt->get_result();
	$syRow = $syResult->fetch_row();
	$sy = $syRow[0];

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_dean_total_sections`(?);");
	$stmt->bind_param('s',$_SESSION['ID']);
	$stmt->execute();
	$sectCount = $stmt->get_result()->fetch_row()[0];

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_dean_endorsed_total`(?);");
	$stmt->bind_param('s',$_SESSION['ID']);
	$stmt->execute();
	$endorsedCount = $stmt->get_result()->fetch_row()[0];


	$stmt = null;
	$stmt = $conn->prepare("CALL `select_dean_not_endorsed_total`(?);");
	$stmt->bind_param('s',$_SESSION['ID']);
	$stmt->execute();
	$notEndorsedCount = $stmt->get_result()->fetch_row()[0];

?><!DOCTYPE html>
<html>
<head>
	<title>Endorse schedules</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
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
	<?php if (isset($_REQUEST["dayRank"])){
		?><script type="text/javascript">
			function fillTable(){
				$.ajax({
					url: "mex/ajax_fragment_to_endorse_v2.php",
					data: { day:'<?php echo $_REQUEST['dayRank'] ?>'},
					success: function(response){
						$("#right-container").html(response);
					}
				});
				return false;
			}
			fillTable();
		</script><?php
	}?>
	
	<?php include "fragment_header.php" ?>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<div class="w3-hide-small">
				<img  src="/images/sys-logo.png" style="width: 100%">
				<br>
				<br>
				<hr>
			</div>
			<?php include 'fragment_starter_warning.php'; ?>
			<?php 
				if($stage == 2 && $isEndorsed == false){
					echo "Period: ". $per . "<br>";
					echo 'SY: ' . $sy . ' - ' . ($sy + 1) . '<br>';
					?><br>
					<button class="w3-button my-blue" style="width: 100%" type="button" onclick="endorse()">Endorse</button>
					<script type="text/javascript">
						function endorse(){
							if(confirm("You won't be able to change the list after this action. Continue?")){
								$.ajax({
									url: "mex/ajax_json_endorse.php",
									dataType: "json",
									success: function(response){
										alert(response.result);
										if(response.sucess){
											window.location = '/';
											//location.reload();
										}
									}
								});
							}
							return false;
						}
					</script>

					<?php
				}
				else{
					?><p class="w3-card w3-yellow w3-padding"><em>Endorsment not open yet.</em></p><?php
				}
			?>
			<p><em>Please do take note that the day shown here are just sudgestions, SDO can still change it.</em></p>
		</div>
		
		<div class="w3-rest w3-container">
			<div class="w3-border-bottom w3-border-blue" id="dayChooser">
				<a class="w3-button day-tabs <?php if(!isset($_REQUEST['dayRank'])) echo 'my-blue';?>" id="deptHomeTab" href="manage_exam_schedule.php" type="button"><i class="fas fa-home" aria-hidden="true"></i></a><?php
					$stmt = null;
					$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('')");
					$stmt->execute();
					$dayResult = $stmt->get_result();
					if ($dayResult->num_rows > 0) {
						while ($dayRow = $dayResult->fetch_assoc()) {
							?><a
								class="w3-button day-tabs <?php if(isset($_REQUEST['dayRank']) && $_REQUEST['dayRank'] == $dayRow['rank']) echo 'my-blue';?>"
								style=""
								href="manage_exam_schedule.php?dayRank=<?php echo $dayRow['rank'] ?>"
								type="button"><?php echo $nf->format($dayRow['rank']) . " day"; ?></a><?php
						}
					}
				?>
			</div>
			<?php
				if (isset($_REQUEST["dayRank"])){
					include "mex/fragment_mex_day_v2.php";
				}
				else{
					include "mex/fragment_mex_home_v2.php"; 
				}
			?>			
		</div>
	</div>
	<?php include "fragment_footer.php" ?>
</body>
</html>