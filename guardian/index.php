<!DOCTYPE html>
<?php
	include_once "../util_dbHandler.php";
	include_once("util_check_session.php");

	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);
?>
<html>
<head>
	<title>Exam schedules</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../css/w3.css">
	<link rel="stylesheet" href="../css/my.css">
	<link rel="stylesheet" href="../css/fontawesome-all.css">
	<style>

	</style>
</head>
<body>
	<script src="/scripts/jquery-3.2.1.min.js"></script>
	<?php include_once "fragment_header.php" ?>
	<div class="w3-row w3-margin-top">
		<div class="my-third w3-container">
			<img class="w3-hide-small" src="/images/sys-logo.png" style="width: 100%">
			<?php include_once "../fragment_changepass_dlg.php" ?>
		</div>
		<div class="w3-rest w3-container">
			<div class="" style="max-width: 640px" id="sched-container">
				<?php
					$stmt = null;
					$stmt = $conn->prepare("SELECT `Bool Val` FROM `dbconfig` WHERE `Name` = 'Exam Visible'");
					#$stmt->bind_param('i', $_REQUEST['q']);
					$stmt->execute();
					$vResult = $stmt->get_result();
					$vRow = $vResult->fetch_row();
					if ($vRow[0] == 1){
						$stmt = null;
						$stmt = $conn->prepare("SELECT `Int Val` FROM `dbconfig` WHERE `Name` = 'Exam Period'");
						#$stmt->bind_param('i', $_REQUEST['q']);
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
						$stmt = $conn->prepare("CALL `select_guardian_sked_count`(?)");
						$stmt->bind_param('s', $_SESSION['ID']);
						$stmt->execute();
						if ($stmt->get_result()->fetch_row()[0] > 0){
							?><h3>Schedules for <?php echo $per; ?><br><label> SY: <?php echo $sy; ?> - <?php echo $sy + 1; ?></label></h3><?php
						
							$stmt = null;
							$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('')");
							#$stmt->bind_param('i', $_REQUEST['q']);
							$stmt->execute();
							$dayResult = $stmt->get_result();
							if ($dayResult->num_rows > 0) {
								?><table style="width: 100%">
								<tr class='' >
									<th>Name</th>
									<th>Start</th>
									<th>End</th>
									<th style="text-align: center;">Room</th>
									<th style="text-align: center;">Section</th>
									<th>Subject</th>
								</tr>
								<tr><td colspan="6" style="border-bottom: 1px solid #0024f4!important;"></td></tr>
								<?php
								while ($dayRow = $dayResult->fetch_assoc()) {

									$stmt = null;
									$stmt = $conn->prepare("CALL `select_guardian_exam_schedule`(?,?)");
									$stmt->bind_param('si', $_SESSION['ID'], $dayRow['Id']);
									$stmt->execute();
									$skedResult = $stmt->get_result();

									if ($skedResult->num_rows > 0) {

										?><tr><td colspan="6"><b><?php echo $nf->format($dayRow['rank']) . " day"; ?> : <?php echo date("l F j, Y", strtotime( $dayRow['Date'])); ?></b></td></tr><?php
										while ($skedRow = $skedResult->fetch_assoc()) {
											?><tr>
												<td><?php echo $skedRow['First Name']; ?></td>
												<td><?php echo date("g:i A", strtotime($skedRow['Start'])); ?></td>
												<td><?php echo date("g:i A", strtotime($skedRow['End'])); ?></td>
												<td style="text-align: center;"><?php echo $skedRow['Room']; ?></td>
												<td style="text-align: center;"><?php echo $skedRow['Section Code Full']; ?></td>
												<td><?php echo $skedRow['Code']; ?></td>
											</tr>
											<?php
										}
									}
									else{
									}
								}
								?></table><?php
							}
						}
						else{
							?>
							<div style="text-align: center;">
								<i class="fas fa-calendar-check-o w3-text-green" aria-hidden="true" style="font-size: 10em;"></i>
								<h4>Schedule is posted and no schedule to show for you.</h4>
								<?php 
									$stmt = null;
									$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('')");
									#$stmt->bind_param('i', $_REQUEST['q']);
									$stmt->execute();
									$dayResult = null;
									$dayResult = $stmt->get_result();
									if ($dayResult->num_rows > 0) {
										while ($dayRow = $dayResult->fetch_assoc()) {
											echo $nf->format($dayRow['rank']) . " day : ";
											echo date("l F j, Y", strtotime( $dayRow['Date'])) . "<br>";
										}
									}
								?>
							</div>
						<?php
						}					
					}
					else{
						?>
							<div style="text-align: center;">
								<i class="fas fa-calendar-minus-o w3-text-green" aria-hidden="true" style="font-size: 10em;"></i>
								<h4>No schedules posted yet</h4>
							</div>
						<?php
					}
				?>
			</div>
			<div class="w3-half">
			</div>
		</div>
	</div>
	<?php include_once "fragment_footer.php" ?>

	<script type="text/javascript">
		function subjTable(id,rank){
			//NOT USED?
			var strBuffer = ""
			$.ajax({
				url: "ajax_table_schedules.php",
				dataType: "json",
				data: {id:id},
				async: false,
				success: function(response){
					if (response.sucess){
						$.each(response.result, function(i, item){
							strBuffer += "<div class='w3-padding w3-container'>" + 
								"<h3>" + rank + "First Day : " + item["Date"] + "</h3>" + 
								"<div class='w3-border-bottom'>" + 
									"<div class='w3-quarter'>" + convertTime24to12(item["Start"]) + " <br> " + convertTime24to12(item["End"]) + "</div>" +
									"<div class='w3-quarter'>" + item["Room"] + "</div>" +
									"<div class='w3-quarter'>" + item[	"Section Code Full"] + "</div>" + 
									"<div class='w3-quarter'>" + item["Code"] + "</div>" + 
								"</div>" + 
								"</div>"; 
						});
					}
					else{
						//$("#proctors").html("Nothing to show");
					}
				}
			});
			return strBuffer;
		}
		

		function convertTime24to12(time24){
			var tmpArr = time24.split(':'), time12;
			if(+tmpArr[0] == 12) {
				time12 = tmpArr[0] + ':' + tmpArr[1] + ' PM';
			}
			else {
				if(+tmpArr[0] == 00) {
					time12 = '12:' + tmpArr[1] + ' AM';
				}
				else {
					if(+tmpArr[0] > 12) {
						time12 = (+tmpArr[0]-12) + ':' + tmpArr[1] + ' PM';
					} else {
						time12 = (+tmpArr[0]) + ':' + tmpArr[1] + ' AM';
					}
				}
			}
			return time12;
		}

		//fillSchedContainer();
	</script>
</body>
</html>