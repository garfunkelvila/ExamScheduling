<?php
	include_once("../../util_dbHandler.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if ($LoggedInAccesID != '5'){
		echo "STOP!!!";
		exit;
	}
	//*********************
	$stmt = null;
	$stmt = $conn->prepare("CALL `delete_endorsed_exams`(?,?);");
	$stmt->bind_param('si',$_SESSION["ID"], $_REQUEST['id']);
	$stmt->execute();
	if ($stmt->affected_rows == 1){
		#echo "Sucesfully deleted";
		$json['sucess'] = true;
		$json['result'] = "Sucesfully deleted";
		echo json_encode($json);
	}
	else{
		#echo "Delete failed";
		$json['sucess'] = false;
		$json['result'] = "Delete failed";
		echo json_encode($json);
	}
?>