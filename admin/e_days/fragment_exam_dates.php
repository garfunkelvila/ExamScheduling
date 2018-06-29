<div id="dates_container" class="w3-center">
	<?php if($stage == 1){
		?><div class="w3-card-4 w3-margin" style="width:3in; height: 2in; display: inline-block; overflow: auto;">
		<header class="w3-container my-blue">
		<h5>Add date</h5>
		</header>
		<form name="frmAddCourse" class="w3-padding" method="POST" onsubmit="return addDate()" autocomplete="off">
			<label for="txbDate">Select date</label>
			<input class="my-input-1 datepicker" type="text" id="txbDate" placeholder="mm/dd/yyyy" required="">
			<br>
			<button class="w3-button my-blue w3-margin" type="submit" >Add</button>
		</form>
	</div><?php
	}?>
	<?php 
		$stmt = null;
		$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('');");
		#$stmt->bind_param('s', $dayId);
		$stmt->execute();
		$udResult = $stmt->get_result();
		if ($udResult->num_rows > 0) {
			while ($udRow = $udResult->fetch_assoc()) {
				?><div class="w3-card-4 w3-margin" style="width:3in; height: 2in; display: inline-block; overflow: auto;">
					<header class="w3-container my-blue">
					<h5>Day <?php echo $udRow['rank']; ?></h5>
					</header>
					<div id="frmView-<?php echo $udRow['Id']; ?>">
						<div class="w3-container">
							<p><b><?php echo date("(l) F j, Y", strtotime($udRow["Date"])); ?></b></p>
							<p>Scheduled: <b><?php
								$stmt = null;
								$stmt = $conn->prepare("SELECT COUNT(`Day Id`) FROM `exam_schedules` WHERE `Day Id` = ?");
								$stmt->bind_param('i', $udRow['Id']);
								$stmt->execute();
								$sResult = $stmt->get_result();
								$sRow = $sResult->fetch_row();
								echo $sRow[0];
							?></b></p>
						</div>
						<div class="w3-center w3-padding">
							<button class="w3-button my-blue" type="button" onclick="toggleEdit('<?php echo $udRow['Id']; ?>')">Change</button><?php
								if ($stage == 1) {
									?><button class="w3-button my-blue" type="button" onclick="deleteDate('<?php echo $udRow['Id']; ?>')">Delete</button><?php
								}
							?>
						</div>
					</div>
					<form id="frmEdit-<?php echo $udRow['Id']; ?>" style="display: none;" onsubmit="return editDate('<?php echo $udRow['Id']; ?>');">
						<div class="w3-container">
							<p><input class="my-input-1 datepicker" type="text" style="text-align: center;" id="txbDate-<?php echo $udRow['Id']; ?>" placeholder="mm/dd/yyyy" required=""></p>
						</div>
						<div class="w3-center w3-padding">
							<button class="w3-button my-blue" type="submit">Ok</button>
							<button class="w3-button my-blue" type="button" onclick="toggleEdit('<?php echo $udRow['Id']; ?>')">Cancel</button>
						</div>
					</form>
				</div><?php
			}
		}
		else{
			
		}
	?>
</div>
<script type="text/javascript">
	function toggleEdit(id){
		$('#frmEdit-' + id).toggle();
		$('#frmView-' + id).toggle();
	}
	function editDate(id){
		$.ajax({
			url: "e_days/ajax_json_update_exam_date.php",
			dataType: "json",
			data: {
				date: $("#txbDate-" + id).val(),
				id: id
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
	<?php
		if ($stage == 1) {
			?>function deleteDate(id){
				$.ajax({
					url: "e_days/ajax_json_delete_exam_date.php",
					dataType: "json",
					data: { id: id },
					success: function(response){
						alert(response["result"]);
						if(response.sucess){
							location.reload();
						}
					}
				});
				return false;
			}<?php
		}
	?>
</script>