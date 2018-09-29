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
#--------------------------
	if (isNotEmpty($_REQUEST['idNumber']) && isNotEmpty($_REQUEST['fName']) && isNotEmpty($_REQUEST['lName'])) {
		$stmt = null;
		$stmt = $conn->prepare("CALL `update_user`(?,?,?,?,?);");
		$stmt->bind_param('sssss',$_SESSION['ID'], $_REQUEST['idNumber'], $_REQUEST['fName'], $_REQUEST['mName'], $_REQUEST['lName']);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			$json['sucess'] = true;
			$json['result'] = "Professor sucesfully edited.";
			echo json_encode($json);
		}
		else{
			$json['result'] = "Edit failed.";
			echo json_encode($json);
		}
	}
	else{
		$json['result'] = "Edit failed. Empty or invalid field.";
		echo json_encode($json);
	}
?>