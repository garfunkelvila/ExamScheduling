<?php
	#COUNT xD
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_exam_schedules_search`(?,?);");
	$stmt->bind_param('ss', $dayId, $q);
	$stmt->execute();
	$usResult = $stmt->get_result();

	$subjCount = 0;
	if ($usResult->num_rows > 0) {
		while ($usRow = $usResult->fetch_assoc()) {
			if (isset($_COOKIE['watchlist']) && (in_array($usRow['ClassId'], json_decode($_COOKIE['watchlist'])))) {
				$subjCount++;
			}
		}
	}
	#-----------------------------------------------------
	if ($subjCount > 0){
		$stmt = null;
		$stmt = $conn->prepare("CALL `select_exam_schedules_search`(?,?);");
		$stmt->bind_param('ss', $dayId, $q);
		$stmt->execute();
		$usResult = $stmt->get_result();
		if ($usResult->num_rows > 0) {
			?><h6><?php echo date("F j, Y (l)", strtotime($dateRow["Date"])); ?></h6>
			<div class="w3-border-top w3-border-blue" style="width: 100%; max-width: 8in; display: table; text-align: center;">
				<div class="w3-container" style="display: table-row;">
				<div class="my-cell" style="width: 0.5in;"><b>Section Code</b></div>
				<div class="my-cell"><b>Subject Code</b></div>
				<div class="my-cell" style="width: 1in;"><b>Time</b></div>
				<div class="my-cell" style="width: 1in;"><b>Room</b></div>
				<div class="my-cell" style="width: 0in;"><b></b></div>
				<!--div class="my-cell" style="width: 0.1in;"><b>No. of Students</b></div-->
			</div><?php
			while ($usRow = $usResult->fetch_assoc()) {
				if (isset($_COOKIE['watchlist']) && (in_array($usRow['ClassId'], json_decode($_COOKIE['watchlist'])))) {
					?><div class="w3-container my-hover-light-grey" style="display: table-row;">
						<div class="my-cell" style="width: 0.5in;"><?php echo $usRow['SectFull']; ?></div>
						<div class="my-cell"><?php echo $usRow['subjectCode']; ?></div>
						<div class="my-cell" style="width: 1in;"><?php echo date("g:i", strtotime($usRow['Start'])) . ' - ' . date("g:i", strtotime($usRow['End'])); ?></div>
						<div class="my-cell" style="width: 1in;"><?php echo $usRow['Room']; ?></div>
						<div class="my-cell" style="">
							<button class="my-button w3-hover-green w3-hover-text-white" onclick="unbookmark('<?php echo $usRow['ClassId']; ?>')"><i class="fas fa-bookmark"></i></button>
						</div>
					</div><?php
				}
			}
			?></div><?php
		}
	}
?>