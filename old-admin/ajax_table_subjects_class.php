<?php
	include "../util_dbHandler.php";
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	#***************************************************
	$stmt = null;
	#$q = str_replace(' ', '%', $_REQUEST['q']);
	$stmt = $conn->prepare("CALL `select_subject_by_section`(?);");
	$stmt->bind_param('s', $_REQUEST["section"]);
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