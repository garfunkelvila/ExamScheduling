<?php
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('');");
	$stmt->execute();
	$dateResult = $stmt->get_result();
	if ($dateResult->num_rows > 0) {
		while ($dateRow = $dateResult->fetch_assoc()) {
			$dayId = $dateRow['Id'];
			include "fragment_bookmarked_subjects_table.php";
		}
	}
?>