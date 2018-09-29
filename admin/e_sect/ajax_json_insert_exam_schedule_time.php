<?php
	include_once("../../util_dbHandler.php");
	include_once("../../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0,
		'm' => false
	);
	$resultArray = array();
	if($LoggedInAccesID != '1'){
		echo "STOP!!! ";
		exit;
	}
	if($_REQUEST['dayId'] == '-'){
		$json['result'] = "Please select the date to fill.";
		echo json_encode($json);
		exit;
	}


	#--- REFORMAT DATE INTO MYSQL
	$myDateTime = DateTime::createFromFormat('h:i a', $_REQUEST['start']);
	$formattedTime = $myDateTime->format('H:i:s');


	if(isNotEmpty($_REQUEST['endorseId']) && isNotEmpty($_REQUEST['dayId']) && isNotEmpty($_REQUEST['room'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `insert_exam_schedule_time`(?,?,?,?);");
		$stmt->bind_param('iiss',$_REQUEST['endorseId'], $_REQUEST['dayId'], $_REQUEST['room'], $formattedTime);
		$stmt->execute();
		$sResult = $stmt->get_result();
		$sRow = $sResult->fetch_row();
		#$sRow[0]

		if ($sRow[0] == 1){
			$json['sucess'] = true;
			$json['result'] = "Schedule sucesfully added.";
			echo json_encode($json);
		}
		else{
			if ($sRow[5] == 1){
				$json['result'] = "Schedule can be merged.";
				$json['m'] = true;
			}
			elseif ($sRow[2] == 0)
				$json['result'] = "Endorsment already exist";
			elseif ($sRow[3] == 0)
				$json['result'] = "Proctor is not available.";
			elseif ($sRow[4] == 0)
				$json['result'] = "Room is not available.";
			elseif ($sRow[1] == 0)
				$json['result'] = "Time is too noon, try another room or day";
			else
				$json['result'] = "Nothing added.";
			echo json_encode($json);
		}
	}
	else{
		$json['result'] = "Adding failed. Empty or invalid field.";
		echo json_encode($json);
	}
?>