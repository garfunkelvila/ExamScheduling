<?php
	include_once "../../util_dbHandler.php";
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if ($LoggedInAccesID != '5'){
		echo "STOP!!!";
		exit;
	}
	#***************************************************
	$stmt = null;
	$stmt = $conn->prepare("SELECT * FROM `courses` WHERE `Department Id` = ? ORDER BY `Name` ASC;");
	$stmt->bind_param('i',$_REQUEST['dept']);
	$stmt->execute();
	$courseResult = $stmt->get_result();
	if ($courseResult->num_rows > 0) {
		while ($courseRow = $courseResult->fetch_assoc()) {
			$resultArray[] = $courseRow;
		}
		$json['sucess'] = true;
		$json['result'] = $resultArray;
		echo json_encode($json);
	}
	else{
		#noting to show?
		$json['sucess'] = false;
		$json['result'] = "Nothing to show";
		echo json_encode($json);
	}
?>