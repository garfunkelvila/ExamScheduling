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
	//-----------------------------------
	if(isNotEmpty($_REQUEST['section']) && isNotEmpty($_REQUEST['subject']) && strlen($_REQUEST['section']) == 1){
		$stmt = null;
		$stmt = $conn->prepare("CALL `insert_class`(?,?,?,?);");
		$stmt->bind_param('ssss',$_SESSION["ID"], $_REQUEST['section'], $_REQUEST['subject'], $_REQUEST['profId']);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			#echo "Subject sucesfully added.";
			$json['sucess'] = true;
			$json['result'] = "Class sucesfully added.";
			echo json_encode($json);
		}
		else{
			$stmt = null;
			$stmt = $conn->prepare("SELECT COUNT(`Id`) FROM `classes` WHERE `Section Code` = ? AND `Subject Id` = ?");
			$stmt->bind_param('ss', $_REQUEST['section'], $_REQUEST['subject']);
			$stmt->execute();
			if ($stmt->get_result()->fetch_row()[0] > 0){
				#echo "Adding failed.";
				$json['sucess'] = false;
				$json['result'] = "Class already exist.";
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