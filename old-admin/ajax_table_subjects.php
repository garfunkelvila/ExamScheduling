<?php
	include "../util_dbHandler.php";
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	//-----------------------------------
	#query dont like null objects
	$courseId = isset($_REQUEST['courseId']) ? $_REQUEST['courseId'] : '';
	$deptId = isset($_REQUEST['deptId']) ? $_REQUEST['deptId'] : '';
	$subjLvl = isset($_REQUEST['subjLvl']) ? $_REQUEST['subjLvl'] : '';
	$q = isset($_REQUEST['q']) ? str_replace(' ', '%', $_REQUEST['q']) : '';
	#$fullSect = isset($_REQUEST['fullSect']) ? $_REQUEST['fullSect'] : '';
	#$q = str_replace(' ', '%', $_REQUEST['q']);

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_subjects`(?,?,?,?);");
	$stmt->bind_param('ssis', $deptId, $courseId, $subjLvl, $q);
	$stmt->execute();
	$subjectResult = $stmt->get_result();
	if ($subjectResult->num_rows > 0) {
		$lastDept = null;
		while ($subjectRow = $subjectResult->fetch_assoc()) {
			$resultArray[] = $subjectRow;
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