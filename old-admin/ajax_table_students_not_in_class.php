<?php
	#ENUMERATE WHERE IT IS USED
	#-popup_manage_class.php
	include_once "../util_dbHandler.php";
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	//-----------------------------------
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_students_not_in_class`(?,?);");
	$stmt->bind_param('si', $_REQUEST['q'], $_REQUEST['classId']);
	$stmt->execute();
	$classResult = $stmt->get_result();
	if ($classResult->num_rows > 0) {
		while ($classRow = $classResult->fetch_assoc()) {
			$resultArray[] = $classRow;
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