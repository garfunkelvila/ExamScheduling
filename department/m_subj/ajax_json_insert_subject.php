<?php
	#TODO:FINISH IT
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
	//-----------------------------------
	if(isNotEmpty($_REQUEST['name']) && isNotEmpty($_REQUEST['code'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `insert_subject`(?,?,?,?,?,?);");
		$stmt->bind_param('sssisi',$_SESSION['ID'], $_REQUEST['name'], $_REQUEST['code'], $_REQUEST['level'], $_REQUEST['courseId'], $_REQUEST['isMajor']);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			$json['sucess'] = true;
			$json['result'] = "Subject sucesfully added.";
			echo json_encode($json);
		}
		else{
			$stmt = null;
			$stmt = $conn->prepare("SELECT COUNT(`Code`) FROM `subjects` WHERE `Code` = ? AND `Course Code` = ?;");
			$stmt->bind_param('ss', $_REQUEST['code'], $_REQUEST['courseId']);
			$stmt->execute();
			if ($stmt->get_result()->fetch_row()[0] > 0){
				$json['sucess'] = false;
				$json['result'] = "Subject code already exist.";
				echo json_encode($json);
			}
			else{
				#echo "Adding failed.";
				$json['sucess'] = false;
				$json['result'] = "Nothing Added.";
				echo json_encode($json);
			}
		}
	}
	else{
		#echo "Adding failed.";
		$json['sucess'] = false;
		$json['result'] = "Adding failed. Empty or invalid field.";
		echo json_encode($json);
	}
?>