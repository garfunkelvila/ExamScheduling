<?php 
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_exam_schedules`(?);");
	$stmt->bind_param('s', $dayId);
	$stmt->execute();
	$usResult = $stmt->get_result();
	if ($usResult->num_rows > 0) {
		?><div class="w3-container" style="display: table-row;">
			<div class="my-cell" style="width: 0.5in;"><b>Section Code</b></div>
			<div class="my-cell"><b>Subject Code</b></div>
			<div class="my-cell" style="width: 1in;"><b>Time</b></div>
			<div class="my-cell" style="width: 1in;"><b>Room</b></div>
			<div class="my-cell" style="width: 0.1in;"><b>Action</b></div>
		</div><?php
		while ($usRow = $usResult->fetch_assoc()) {
			?><div class="w3-container my-hover-light-grey" style="display: table-row;">
				<div class="my-cell" style="width: 0.5in;"><?php echo $usRow['SectFull']; ?></div>
				<div class="my-cell"><?php echo $usRow['subjectCode']; ?></div>
				<div class="my-cell" style="width: 1in;"><?php echo date("g:i", strtotime($usRow['Start'])) . ' - ' . date("g:i", strtotime($usRow['End'])); ?></div>
				<div class="my-cell" style="width: 1in;"><?php echo $usRow['Room']; ?></div>
				<div class="my-cell" style="width: 0.1in; white-space: nowrap;">
					<button title="Edit" class="my-button w3-hover-green w3-hover-text-white" onclick="showEditSked('<?php echo $usRow['Id']; ?>')">
						<i class="far fa-edit"></i>
					</button><button title="Remove" class="my-button w3-hover-red w3-hover-text-white" onclick="deleteSection('<?php echo $usRow['Id']; ?>')">
						<i class="fas fa-eraser"></i> Remove
					</button>
				</div>
			</div><?php
		}
	}
	else{
		echo "No schedule to show";
	}
?>