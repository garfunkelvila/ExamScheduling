<?php
	include("../../util_dbHandler.php");
	$json = array(
		'teacher' => '',
		'id' => '',
		'isMajor' => '0'
	);
	$resultArray = array();
	if ($LoggedInAccesID != '5'){
		echo "STOP!!!";
		exit;
	}

	if($_REQUEST['sect'] == '-' || $_REQUEST['subj'] == '-'){
		$json['idNum'] = "---";
		$json['isMajor'] = '0';
		$json['teacher'] = "---";
		echo json_encode($json);
		exit;
	}

	$stmt = null;
	$stmt = $conn->prepare("CALL `select_teacher_from_class`(?,?);");
	$stmt->bind_param('si', $_REQUEST['sect'], $_REQUEST['subj']);
	$stmt->execute();
	$lResult = $stmt->get_result();

	if ($lResult->num_rows == 1){
		$row = $lResult->fetch_row();
		$json['idNum'] = $row[0];
		$json['teacher'] = $row[1];
		$json['isMajor'] = $row[2];
		echo json_encode($json);
	}
	else{
		$json['isMajor'] = '0';
		$json['teacher'] = "Err.";
		$json['idNum'] = 'Err';
		echo json_encode($json);
	}
?>