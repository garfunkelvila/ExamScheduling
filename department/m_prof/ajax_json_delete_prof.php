<?php
	include("../../util_dbHandler.php");
	include("../../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if ($LoggedInAccesID != '5'){
		echo "STOP!!!";
		exit;
	}
#--------------------------
	$stmt = null;
	$stmt = $conn->prepare("CALL `delete_professor`(?,?);"); #Change to delete user
	$stmt->bind_param('ss',$_SESSION['ID'], $_REQUEST['idNumber']);
	$stmt->execute();
	if ($stmt->affected_rows == 1){
		$json['sucess'] = true;
		$json['result'] = "Delete sucessfull";
		echo json_encode($json);
	}
	else{
		$json['result'] = "Delete failed.";
		echo json_encode($json);	
	}
	
?>