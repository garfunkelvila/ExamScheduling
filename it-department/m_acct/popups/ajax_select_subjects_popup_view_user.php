<?php
	include "../../../util_dbHandler.php";
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if ($LoggedInAccesID != '6'){
		echo 'STOP!!!';
		exit;
	}
	#***************************************************
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_subject_not_enrolled`(?,?)");
	$stmt->bind_param('ss', $_REQUEST['q'], $_REQUEST['idNum']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	if ($sResult->num_rows > 0) {
		while ($sRow = $sResult->fetch_assoc()) {
			$resultArray[] = $sRow;
		}
		$json['sucess'] = true;
		$json['result'] = $resultArray;
		echo json_encode($json);
	}
	else{
		$json['sucess'] = false;
		echo json_encode($json);
	}
?>