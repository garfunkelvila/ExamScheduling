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

	if (isNotEmpty($_REQUEST['idNumber'])) {
		$stmt = null;
		$stmt = $conn->prepare("CALL `insert_prof_department`(?,?);");
		$stmt->bind_param('ss',$_SESSION['ID'], $_REQUEST['idNumber']);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			$json['sucess'] = true;
			$json['result'] = "Transfer sucessfull";
			echo json_encode($json);
		}
		else{
			#echo "Registration failed.";
			$json['sucess'] = false;
			$json['result'] = "Transfer failed.";
			echo json_encode($json);			
		}
	}
	else{
		#echo "Registration failed. A field is empty.";
		$json['sucess'] = false;
		$json['result'] = "Transfer failed. A field is empty.";
		echo json_encode($json);
	}
?>