<?php
	include_once "../util_dbHandler.php";
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	#***************************************************
	$currentDepartment = "";
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_student_exam_schedule`(?,?)");
	$stmt->bind_param('si', $_SESSION["ID"],$_REQUEST["id"]);
	$stmt->execute();
	$courseResult = $stmt->get_result();
	if ($courseResult->num_rows > 0) {
		while ($courseRow = $courseResult->fetch_assoc()) {
			$resultArray[] = $courseRow;
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