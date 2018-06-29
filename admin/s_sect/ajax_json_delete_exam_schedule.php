<?php
	include("../../util_dbHandler.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if($LoggedInAccesID != '1'){
		echo "STOP!!! ";
		exit;
	}

	$stmt = null;
	$stmt = $conn->prepare("CALL `delete_exam_schedule`(?,?);");
	$stmt->bind_param('si',$_SESSION['ID'], $_REQUEST['q']);
	$stmt->execute();
	if ($stmt->affected_rows == 1){
		$json['sucess'] = true;
		$json['result'] = "Sucesfully deleted.";
		echo json_encode($json);
	}
	else{
		$json['sucess'] = false;
		$json['result'] = "Delete failed.";
		echo json_encode($json);
	}
?>