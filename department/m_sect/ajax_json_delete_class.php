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
	
	$stmt = null;
	$stmt = $conn->prepare("CALL `delete_class`(?,?);");
	$stmt->bind_param('ss',$_SESSION["ID"], $_REQUEST['q']);
	$stmt->execute();
	$lResult = $stmt->get_result();
	$lRow = $lResult->fetch_row();
	$isOk = $lRow[0];
	if ($isOk == 1){
		$json['sucess'] = true;
		$json['result'] = "Section sucesfully deleted.";
		echo json_encode($json);
	}
	else{
		$json['sucess'] = false;
		$json['result'] = "Delete failed.";
		echo json_encode($json);
	}
?>