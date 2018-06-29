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
	//-----------------------------------
	$stmt = null;
	$stmt = $conn->prepare("CALL `insert_student_to_class`(?,?);");
	$stmt->bind_param('is',$_REQUEST['classId'], $_REQUEST['userId']);
	$stmt->execute();
	$classResult = $stmt->get_result();
	if ($stmt->affected_rows == 1) {
		$json['sucess'] = true;
		$json['result'] = "Student sucesfully added.";;
		echo json_encode($json);
	}
	else{
		#resulted nothing
		$json['sucess'] = false;
		$json['result'] = "Nothing Added";
		echo json_encode($json);
	}
?>