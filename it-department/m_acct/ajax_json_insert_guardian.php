<?php
	#Used in registering the student
	include_once("../../util_dbHandler.php");
	include_once("../../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if ($LoggedInAccesID != '6'){
		echo 'STOP!!!';
		exit;
	}
	#***************************
	
	if (isNotEmpty($_REQUEST['idNumber']) && isNotEmpty($_REQUEST['fName']) && isNotEmpty($_REQUEST['lName'])) {
		$password = getDefPassword($_REQUEST['idNumber']);
		$stmt = null;
		$stmt = $conn->prepare("CALL `reg_guardian_pre_reg`(?,?,?,?,?,?,?);");
		$stmt->bind_param('sisssss', $_SESSION['ID'], $_REQUEST['tId'], $_REQUEST['idNumber'], $password, $_REQUEST['fName'], $_REQUEST['mName'], $_REQUEST['lName']);
		$stmt->execute();

		$sRow = $stmt->get_result()->fetch_row();

		if($sRow[0] != 0){
			#zero means ID already exist
			$json['sucess'] = false;
			$json['result'] = $sRow[1];
			echo json_encode($json);
		}
		else{
			$json['sucess'] = true;
			$json['result'] = "Registration sucesfull.";
			echo json_encode($json);
		}
	}
	else{
		$json['sucess'] = false;
		$json['result'] = "Registration failed. Information might be incomplete.";
		echo json_encode($json);
	}
?>