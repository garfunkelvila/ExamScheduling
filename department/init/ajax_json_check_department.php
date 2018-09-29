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
	//*********************
	if(isNotEmpty($_REQUEST['deptName']) && isNotEmpty($_REQUEST['deptAccr'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `check_department`(?,?,?);");
		$stmt->bind_param('sss',$_SESSION['ID'], $_REQUEST['deptName'], $_REQUEST['deptAccr']);
		$stmt->execute();

		$sResult	= $stmt->get_result();
		$sRow		= $sResult->fetch_row();
		$isNameOk	= $sRow[0];
		$isAcronymOk = $sRow[1];
		if (!$isNameOk){
			$json['sucess'] = false;
			$json['result'] = "Name not available";
			echo json_encode($json);
			exit;
		}
		
		if (!$isAcronymOk){
			$json['sucess'] = false;
			$json['result'] = "Accronym not available";
			echo json_encode($json);
			exit;
		}

		$json['sucess'] = true;
		$json['result'] = $isNameOk . " " . $isAcronymOk;
		echo json_encode($json);
		exit;
	}
	else{
		#echo "Adding failed.";
		$json['sucess'] = false;
		$json['result'] = "Empty field.";
		echo json_encode($json);
	}
?>