<?php
	include "../../../util_dbHandler.php";
	if($LoggedInAccesID != '1'){
		echo "STOP!!! ";
		exit;
	}

	$stmt = null;
	$stmt = $conn->prepare("SELECT `Room`, `Start`,`Day Id` FROM `exam_schedules` WHERE `Id` = ?");
	$stmt->bind_param('s', $_REQUEST['id']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	
	$Room = $sRow[0];
	$Start = date("h:i A", strtotime($sRow[1]));
	$DayId = $sRow[2];

?>
<div class="w3-modal-content" style="max-width: 3in;">
	<header class="w3-container my-blue">
		<h4>Edit</h4>
	</header>

	<div class="w3-container">
		<p>Section Code: <b>TDB id:<?php echo $DayId; ?></b><br>
			<input type="checkbox" id="tAuto" name="" onclick="chkTimeStack()"> <label for="tAuto">Use time stacking</label>
		</p>
		<form id="frmUpdate" onsubmit="return updateSection('<?php echo $_REQUEST['id']; ?>');">
			<table style="width: 100%">
				<tr>
					<td>Room: </td>
					<td>
						<input class="my-input-1" type="text" style="text-align: center;" id="txbRoom" placeholder="Room" value="<?php echo $Room; ?>" required>
					</td>
				</tr>
				<tr id="rTime">
					<td>Time: </td>
					<td><input class="timePicker my-input-1" style="text-align: center;" type="text" id="txbTime" placeholder="Select a time" value="<?php echo $Start; ?>" required></td>
				</tr>
				<tr>
					<td>Day: </td>
					<td><select class="my-input-1" id="optDay">
						<option value="-">-Select a date-</option><?php 
							$stmt = null;
							$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('');");
							$stmt->execute();
							$dResult = $stmt->get_result();
							if ($dResult->num_rows > 0) {
								while ($dRow = $dResult->fetch_assoc()) {
									?><option value="<?php echo $dRow["Id"] ?>"
											  <?php if($dRow["Id"] == $DayId) echo 'Selected'; ?>>
										<?php echo date("F j, Y (l)", strtotime($dRow["Date"])); ?>
									</option><?php
								}
							}
						?>
					</select>
					</td>
				</tr>
			</table>
			<div class=" w3-margin w3-right">
				<button class="my-button my-blue" style="" type="submit">Ok</button>
				<button class="my-button my-blue" style="" type="button" onclick="document.getElementById('editSked').style.display='none'">Cancel</button>
			</div>
		</form>
		
	</div>
</div>
<script type="text/javascript">
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