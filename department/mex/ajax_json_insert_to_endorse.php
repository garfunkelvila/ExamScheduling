<?php
	include_once("../../util_dbHandler.php");
	include_once("../../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if ($LoggedInAccesID != '5'){
		echo "STOP!!!";
		exit;
	}
	//-----------------------------------
	$stmt = null;
	$stmt = $conn->prepare("CALL `insert_endorsed_exams_v2`(?,?,?,?,?);");
	$stmt->bind_param('ssssi',$_SESSION['ID'], $_REQUEST['id'], $_REQUEST['span'], $_REQUEST['profId'], $_REQUEST['day']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$isOk = $sRow[0];
	#$LoggedInAccesID = $sRow[2];

	if ($isOk == 1){
		#echo "Subject sucesfully added.";
		$json['sucess'] = true;
		$json['result'] = "Section sucesfully added.";
		echo json_encode($json);
	}
	else{
		#echo "Adding failed.";
		$json['sucess'] = false;
		$json['result'] = "Adding failed.";
		echo json_encode($json);
	}
?>