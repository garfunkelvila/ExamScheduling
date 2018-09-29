<?php
	include_once("../../util_dbHandler.php");
	include_once("../../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if($LoggedInAccesID != '1'){
		echo "STOP!!! ";
		exit;
	}

	#---
	$stmt = null;
	$stmt = $conn->prepare("CALL `delete_exam_date`(?,?);");
	$stmt->bind_param('ss',$_SESSION['ID'], $_REQUEST['id']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$isOk = $sRow[0];
	
	if ($isOk == 1){
		$json['sucess'] = true;
		$json['result'] = "Date sucesfully deleted.";
		echo json_encode($json);
	}
	else{
		$json['result'] = "Delete failed.";
		echo json_encode($json);
	}
?>