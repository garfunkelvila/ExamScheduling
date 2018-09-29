<?php
	#This thing returns the sections that doesnt have schedules
	include_once "../util_dbHandler.php";
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	#***************************************************
	$stmt = null;
	#$q = str_replace(' ', '%', $_REQUEST['q']);
	$stmt = $conn->prepare("CALL `select_section_no_skeds`();");
	#$stmt->bind_param('s', $q);
	$stmt->execute();
	$deptResult = $stmt->get_result();
	if ($deptResult->num_rows > 0) {
		while ($deptRow = $deptResult->fetch_assoc()) {
			$resultArray[] = $deptRow;
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