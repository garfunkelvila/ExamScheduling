<?php
	include_once("../util_dbHandler.php");
	include_once("../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	//-----------------------------------
	if(isNotEmpty($_REQUEST['exDate'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `insert_exam_date`(?,?);");
		$stmt->bind_param('ss',$_SESSION['ID'], $_REQUEST['exDate']);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			$json['sucess'] = true;
			$json['result'] = "Date sucesfully added.";
			echo json_encode($json);
		}
		else{
			#check if existing
			$stmt = null;
			$stmt = $conn->prepare("SELECT COUNT(`Date`) FROM `exam_dates` WHERE `Date` = ?");
			$stmt->bind_param('s', $_REQUEST['exDate']);
			$stmt->execute();
			if ($stmt->get_result()->fetch_row()[0] > 0){
				#echo "Adding failed.";
				$json['sucess'] = false;
				$json['result'] = "Date already exist.";
				echo json_encode($json);
			}
			elseif($_REQUEST['exDate'] == date("Y-m-d")){
				$json['sucess'] = false;
				$json['result'] = "Cant set at current date.";
				echo json_encode($json);
			}
			elseif($_REQUEST['exDate'] <= date("Y-m-d")){
				$json['sucess'] = false;
				$json['result'] = "Cant set at past.";
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