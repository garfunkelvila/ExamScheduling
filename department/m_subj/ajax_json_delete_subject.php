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
	$stmt = $conn->prepare("CALL `delete_subject`(?,?);");
	$stmt->bind_param('si',$_SESSION["ID"], $_REQUEST['q']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$isOk = $sRow[0];
	if ($isOk == 1){
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