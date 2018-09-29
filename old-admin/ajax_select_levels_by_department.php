<?php
	include_once "../util_dbHandler.php";
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	//-----------------------------------
	$courseId = isset($_REQUEST['courseId']) ? $_REQUEST['courseId'] : '';

	$stmt = null;
	$stmt = $conn->prepare("SELECT DISTINCT `Year Level` FROM `subjects` WHERE `Course Code` = ? ORDER BY `Year Level`;");
	$stmt->bind_param('s', $courseId);
	$stmt->execute();
	$levelResult = $stmt->get_result();
	if ($levelResult->num_rows > 0) {
		$lastDept = null;
		while ($levelRow = $levelResult->fetch_assoc()) {
			$resultArray[] = $levelRow;
		}
		$json['sucess'] = true;
		$json['result'] = $resultArray;
		echo json_encode($json);
	}
	else{
		#resulted nothing
		$json['sucess'] = false;
		echo json_encode($json);
	}
?>