<?php
	include("../../util_dbHandler.php");
	include("../../util_validations.php");

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
	if ($LoggedInAccesID == '5'){
		$stmt = null;
		$stmt = $conn->prepare("UPDATE `departments` SET `isEndorsed` = '1' WHERE `Dean_Id` = ?;");
		$stmt->bind_param('s',$_SESSION['ID']);
		$stmt->execute();

		if ($stmt->affected_rows == 1){
			$json['sucess'] = true;
			$json['result'] = "Sucesfully endorsed.";
			echo json_encode($json);
		}
		else{
			$json['sucess'] = false;
			$json['result'] = "Endorse failed.";
			echo json_encode($json);
		}
	}
	else{
		echo "STOP!!!";
	}
?>