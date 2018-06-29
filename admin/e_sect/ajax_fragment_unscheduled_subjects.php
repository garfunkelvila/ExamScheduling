<?php
	include "../../util_dbHandler.php";
	#$stmt = null;
	#$stmt = $conn->prepare("SELECT `isEndorsed` FROM `departments` WHERE `Dean_Id` = ?");
	#$stmt->bind_param('s',$_SESSION['eId']);
	#$stmt->execute();
	#$sResult = $stmt->get_result();
	#$sRow = $sResult->fetch_row();
	#$isEndorsed = $sRow[0];
	#-------------------------------------------------------------------------------------
	$locale = 'en_US';
	$nf = new NumberFormatter($locale, NumberFormatter::ORDINAL);

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_sdo_unscheduled_subjects`();");
	#$stmt->bind_param('s', $_SESSION['ID']);
	$stmt->execute();
	$usResult = $stmt->get_result();
	if ($usResult->num_rows > 0) {
		?><div class="w3-container" style="display: table-row;">
			<div class="my-cell" style="width: 0in;"><b>From</b></div>
			<div class="my-cell"><b>Subject Code</b></div>
			<div class="my-cell" style="width: 0.5in;"><b>Section</b></div>
			<div class="my-cell" style="width: 1in;"><b>Proctor</b></div>
			<div class="my-cell" style="width: 1in;"><b>Room</b></div>
			<div class="my-cell w3-hide-small" style="width: 1in;"><b>Time</b></div>
			<div class="my-cell" style="width: 0.5in; text-align: center;"><b>Day</b></div>
			<div class="my-cell" style="width: 0.75in; text-align: center;"><b>Span (hrs)</b></div>
			<div class="my-cell" style="width: 0.75in;"><b>Action</b></div>
		</div><?php
		while ($usRow = $usResult->fetch_assoc()) {
			?><form onsubmit="return addSection('<?php echo $usRow['eId']; ?>')" class="w3-container my-hover-light-grey" style="display: table-row;">
				<div class="my-cell"><?php echo $usRow['dean']; ?></div>
				<div class="my-cell"><?php echo $usRow['subjCode']; ?></div>
				<div class="my-cell" style="width: 0.5in; text-align: center;"><?php echo $usRow['sectFull']; ?></div>
				<div class="my-cell"><?php echo $usRow['proctor']; ?></div>
				<div class="my-cell" style="width: 1in;"><input class="my-input-1" type="text" placeholder="Room" id="room-<?php echo $usRow['eId']; ?>" style="width: 100%" required></div>
				<div class="my-cell w3-hide-small" style="width: 1in; white-space: nowrap;">
					<input type="checkbox" id="ovT-<?php echo $usRow['eId']; ?>" onchange="chkTimeOverride('<?php echo $usRow['eId']; ?>')">
					<label for="ovT-<?php echo $usRow['eId']; ?>" id="lblT-<?php echo $usRow['eId']; ?>">Override</label>
					<input class="my-input-2 timePicker" style="display: none; width: 0.8in" type="text" id="editT-<?php echo $usRow['eId']; ?>" placeholder="hh:mm tt" value="02:00 pm" required disabled>
				</div>
				<div class="my-cell" style="width: 0.5in; text-align: center;"><?php echo $nf->format($usRow['day']); ?></div>
				<div class="my-cell" style="width: 0.75in; text-align: center;"><?php echo ($usRow['span'] / 60);?></div>
				<div class="my-cell" style="width: 0.75in; white-space: nowrap;"><?php
					if ($usRow['Endorsed']){
						?><!--button title="Merge class" class="my-button w3-hover-green w3-hover-text-white" type="button">
							<i class="fas fa-link"></i>
						</button--><button title="Add" class="my-button w3-hover-green w3-hover-text-white btnAdd" type="submit">
							<i class="fas fa-plus" aria-hidden="true"></i> Add
						</button><?php
					}
					else{
						echo 'Not done';
					}
				?></div>
			</form><?php
		}
	}
	else{
		echo "No endorsment to show";
	}
?>
<script type="text/javascript">
	function chkTimeOverride(id){
		$("#lblT-" + id).toggle();
		$("#editT-" + id).toggle();
		

		if (document.getElementById("ovT-" + id).checked == true){
			$("#editT-" + id).prop('disabled',false);
			$("#editT-" + id).focus();
		}
		else{
			$("#editT-" + id).prop('disabled',true);
		}
	}

	$( function() {
		$('.timePicker').each(function(){
			$(this).timepicker({
				timeFormat: "hh:mm tt",
				hourMin: 8,
				hourMax: 17,
				stepMinute: 10
			});
		});
		//$( ".txbDate" ).datepicker({minDate: 0});
	});
</script>