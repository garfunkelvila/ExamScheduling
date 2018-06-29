<?php
	include("../../util_dbHandler.php");
	include("../../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if($LoggedInAccesID != '1'){
		echo "STOP!!! ";
		exit;
	}
	#--- REFORMAT DATE INTO MYSQL
	$myDateTime = DateTime::createFromFormat('m/d/Y', $_REQUEST['date']);
	$formattedDate = $myDateTime->format('Y-m-d');

	#$formattedDate = date("YYYY-mm-dd", strtotime($_REQUEST['date']));
	#---
	$stmt = null;
	$stmt = $conn->prepare("CALL `insert_exam_date`(?,?);");
	$stmt->bind_param('ss',$_SESSION['ID'], $formattedDate);
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	if ($sRow[0] == 1){
		$json['sucess'] = true;
		$json['result'] = "Date sucesfully added.";
		echo json_encode($json);
	}
	else{
		$json['result'] = "Adding failed.";
		echo json_encode($json);
	}
?>