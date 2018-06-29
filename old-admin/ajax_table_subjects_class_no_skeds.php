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
	$stmt = $conn->prepare("SELECT `subjects`.`Code` FROM `classes` JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id` WHERE `classes`.`Section Code Full` = ? AND `classes`.`Id` NOT IN (SELECT `Class Id` FROM `exam_schedules`)");
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