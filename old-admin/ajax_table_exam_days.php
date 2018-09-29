<?php
	include_once "../util_dbHandler.php";
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	//-----------------------------------
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_exam_dates_ranked`('');");
	$stmt->execute();
	$Result = $stmt->get_result();
	if ($Result->num_rows > 0) {
		while ($Row = $Result->fetch_assoc()) {
			$resultArray[] = $Row;
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