<?php
	include("../../util_dbHandler.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if ($LoggedInAccesID != '6'){
		echo 'STOP!!!';
		exit;
	}

	$stmt = null;
	$stmt = $conn->prepare("DELETE FROM `student_class_pre_reg` WHERE `Id` = ?;");
	$stmt->bind_param('i',$_REQUEST['classId']);
	$stmt->execute();
	if ($stmt->affected_rows == 1){
		$json['sucess'] = true;
		$json['result'] = "Sucesfully removed from class.";
		echo json_encode($json);
	}
	else{
		$json['sucess'] = false;
		$json['result'] = "Remove failed.";
		echo json_encode($json);
	}
?>