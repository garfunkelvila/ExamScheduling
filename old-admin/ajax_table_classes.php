<?php
	include_once "../util_dbHandler.php";
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	//-----------------------------------
	#query dont like null objects
	$courseId = isset($_REQUEST['courseId']) ? $_REQUEST['courseId'] : '';
	#$deptId = isset($_REQUEST['deptId']) ? $_REQUEST['deptId'] : '';
	$subjLvl = isset($_REQUEST['subjLvl']) ? $_REQUEST['subjLvl'] : '';
	#$q = isset($_REQUEST['q']) ? str_replace(' ', '%', $_REQUEST['q']) : '';
	#$q = str_replace(' ', '%', $_REQUEST['q']);
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_classes`(?,?);");
	$stmt->bind_param('si', $courseId, $subjLvl);
	$stmt->execute();
	$classResult = $stmt->get_result();
	if ($classResult->num_rows > 0) {
		while ($classRow = $classResult->fetch_assoc()) {
			$stmt = null;
			$stmt = $conn->prepare("SELECT COUNT(`Id`) AS `count` FROM `class_students` WHERE `Class Id` = ?");
			$stmt->bind_param('i', $classRow['id']);
			$stmt->execute();

			$sResult = $stmt->get_result();
			$sRow = $sResult->fetch_row();

			$resultArray[] = $classRow;
			#$resultArray[] = $sRow[0];
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