<?php
	include("../util_dbHandler.php");
	include("../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	#**********************
	$stmt = null;
	$stmt = $conn->prepare("SELECT * FROM `subjects` WHERE `Course Code` = ? AND `Year Level` = ?;");
	$stmt->bind_param('si',$_REQUEST['course'], $_REQUEST['level']);
	$stmt->execute();
	$subjResult = $stmt->get_result();
	if ($subjResult->num_rows > 0) {
		while ($subjRow = $subjResult->fetch_assoc()) {
			$resultArray[] = $subjRow;
		}
		$json['sucess'] = true;
		$json['result'] = $resultArray;
		echo json_encode($json);
	}
	else{
		$json['sucess'] = false;
		$json['result'] = "Nothing to show";
		echo json_encode($json);
	}
?>