<?php
	include_once("../util_dbHandler.php");
	include_once("../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	//-----------------------------------
	if(isNotEmpty($_REQUEST['newDate'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `update_exam_date`(?,?,?);");
		$stmt->bind_param('sss',$_SESSION['ID'], $_REQUEST['dateId'], $_REQUEST['newDate']);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			$json['sucess'] = true;
			$json['result'] = "Date sucesfully edited.";
			echo json_encode($json);
		}
		else{
			#check if existing
			$stmt = null;
			$stmt = $conn->prepare("SELECT COUNT(`Date`) FROM `exam_dates` WHERE `Date` = ?");
			$stmt->bind_param('s', $_REQUEST['newDate']);
			$stmt->execute();
			if ($stmt->get_result()->fetch_row()[0] > 0){
				#echo "Adding failed.";
				$json['sucess'] = false;
				$json['result'] = "Date already exist.";
				echo json_encode($json);
			}
			elseif($_REQUEST['newDate'] == date("Y-m-d")){
				$json['sucess'] = false;
				$json['result'] = "Cant set at current date.";
				echo json_encode($json);
			}
			elseif($_REQUEST['newDate'] <= date("Y-m-d")){
				$json['sucess'] = false;
				$json['result'] = "Cant set at past.";
				echo json_encode($json);
			}
			else{
				#echo "Adding failed.";
				$json['sucess'] = false;
				$json['result'] = "Nothing edited.";
				echo json_encode($json);
			}
		}
	}
	else{
		#echo "Adding failed.";
		$json['sucess'] = false;
		$json['result'] = "Update failed. Empty or invalid field.";
		echo json_encode($json);
	}
?>