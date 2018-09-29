<?php
	include_once("../../util_dbHandler.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if($LoggedInAccesID != '1'){
		echo "STOP!!! ";
		exit;
	}
	
	#****************************
	$stmt = null;
	$stmt = $conn->prepare("CALL `flip_exam_visibility`('')");
	#$stmt->bind_param('ss', $pass, $_SESSION['ID']);
	$stmt->execute();

	if ($stmt->affected_rows == 1){
		$json['sucess'] = true;
		$json['result'] = "Sucesfully changed";
		echo json_encode($json);
	}
	else{
		$json['sucess'] = false;
		$json['result'] = "Change failed";
		echo json_encode($json);
	}
?>