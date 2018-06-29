<?php
	include "../../../util_dbHandler.php";
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if ($LoggedInAccesID != '6'){
		echo 'STOP!!!';
		exit;
	}
	//---------------------

	$stmt = null;
	$stmt = $conn->prepare("CALL `insert_guardian_monitor`(?, ?);");
	$stmt->bind_param('is', $_REQUEST['tUserId'], $_REQUEST['studentId']);
	$stmt->execute();
	if($stmt->get_result()->fetch_row()[0] == 0){
		$json['sucess'] = true;
		$json['result'] = "OK";
		echo json_encode($json);
	}
	else{
		$json['sucess'] = false;
		$json['result'] = "Student already exist";
		echo json_encode($json);
	}
?>