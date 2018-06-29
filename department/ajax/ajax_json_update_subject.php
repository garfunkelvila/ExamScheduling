<?php
	include("../util_dbHandler.php");
	include("../util_validations.php");
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
	if(isNotEmpty($_REQUEST['subjName']) && isNotEmpty($_REQUEST['subjCode']) && isNotEmpty($_REQUEST['q'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `update_subject`(?,?,?,?);");
		$stmt->bind_param('siss',$_SESSION['ID'], $_REQUEST['q'], $_REQUEST['subjName'], $_REQUEST['subjCode']);
		$stmt->execute();
		$subjCodeCount = $stmt->get_result()->fetch_row()[0];

		if ($subjCodeCount == 0){
			$json['sucess'] = true;
			$json['result'] = "Subject sucesfully edited.";
			echo json_encode($json);
		}
		else{
			$json['sucess'] = false;
			$json['result'] = "Subject code already exist.";
			echo json_encode($json);
		}
	}
	else{
		#echo "Edit failed.";
		$json['sucess'] = false;
		$json['result'] = "Edit failed. Empty or invalid field.";
		echo json_encode($json);
	}
?>