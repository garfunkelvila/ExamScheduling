<!DOCTYPE html>
<?php
	#TRANSFERED AND COPIED MIGHT SOON BE OBSOLETE
	include "../util_dbHandler.php";
	include("util_check_session.php");
	include("../util_check_stage.php");

	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

?>
<html>
<head>
	<title>Exam Dates</title>
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
				if ($stage == 1){
					$stmt = null;
					$stmt = $conn->prepare("SELECT COUNT(`id`) FROM `exam_dates`");
					$stmt->execute();
					$sResult = $stmt->get_result();
					$sRow = $sResult->fetch_row();
					$dCount = $sRow[0];

					if ($dCount>0){
						?><form onsubmit="return updateStatus()">
							<p><em class="w3-tiny">Please do take note that <b>day</b> and <b>period</b> can't be changed after pressing finish.</em></p>
							<select class="my-input-1" id="period" onchange="validatePeriod()">
								<option value="-">Select a period</option>
								<option value="1">Prelim</option>
								<option value="2">Midterm</option>
								<option value="3">Finals</option>
							</select>
							<br><br>
							<button class="w3-button my-blue" style="width: 100%" onclick="">Finish</button>
						</form>


						
						<script type="text/javascript">
							function validatePeriod(){
								if($('#period').val() == '-'){
									$('#period').get(0).setCustomValidity("Please select a period");
									return false;
								}
								else{
									$('#period').get(0).setCustomValidity("");
									return true;
								}
							}
							function updateStatus(){
								if(!validatePeriod())
									return false;
								if (confirm("Please do take note that day can't be changed after after this action. Continue?")) {
									$.ajax({
										url: "e_days/ajax_json_update_status.php",
										data: {
											period: $('#period').val()
										},
										dataType: "json",
										success: function(response){
											if(response.sucess){
												alert(response["result"]);
												location.reload();
											}
											else{
												alert(response["result"]);
											}
										}
									});
								}
								return false;
							}
						</script>
						<?php
					}
				}
				else{
					?><p class="w3-card w3-yellow w3-padding"><em>Endorsment and encoding state.</em></p><?php
				}
			?>
			

			<script type="text/javascript">
				$( function() {
					$('.datepicker').each(function(){
						$(this).datepicker({
							minDate: 0,
							maxDate: 30
						});
					});

					//$( ".txbDate" ).datepicker({minDate: 0});
				});
				function addDate(){
					$.ajax({
						url: "e_days/ajax_json_insert_exam_date.php",
						dataType: "json",
						data: {
							date: $("#txbDate").val()
						},
						success: function(response){
							alert(response["result"]);
							if(response.sucess){
								location.reload();
							}
						}
					});
					return false;
				}
			</script>
		</div>
		
		<div class="w3-rest w3-container">
			<h5 class="w3-border-bottom w3-border-blue">Exam dates</h5>
			<?php 
				include "e_days/fragment_exam_dates.php"; 
			?>		
		</div>
	</div>
	<?php include "fragment_footer.php" ?>
</body>
</html>