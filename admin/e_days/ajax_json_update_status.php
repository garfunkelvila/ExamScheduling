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
	
	$stmt = null;
	$stmt = $conn->prepare("UPDATE `dbconfig` SET `Int Val` = ? WHERE `Name` = 'Exam Period';");
	$stmt->bind_param('i', $_REQUEST['period']);
	$stmt->execute();

	$stmt = null;
	$stmt = $conn->prepare("UPDATE `dbconfig` SET `Int Val` = '2' WHERE `Name` = 'Stage' ;");
	$stmt->execute();
	if ($stmt->affected_rows == 1){
		$json['sucess'] = true;
		$json['result'] = "Status updated.";
		echo json_encode($json);
	}
	else{
		$json['result'] = "Update failed.";
		echo json_encode($json);
	}
?>