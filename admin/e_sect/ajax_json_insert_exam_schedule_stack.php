<?php
	include("../../util_dbHandler.php");
	include("../../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if($LoggedInAccesID != '1'){
		echo "STOP!!! ";
		exit;
	}
	if(isNotEmpty($_REQUEST['dayId']) == false){
		$json['sucess'] = false;
		$json['result'] = "Please select a date";
		echo json_encode($json);
		exit;
	}


	if(isNotEmpty($_REQUEST['endorseId']) && isNotEmpty($_REQUEST['dayId']) && isNotEmpty($_REQUEST['room'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `insert_exam_schedule_stack`(?,?,?);");
		$stmt->bind_param('iis',$_REQUEST['endorseId'], $_REQUEST['dayId'], $_REQUEST['room']);
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
			if ($sRow[1] == 0)
				$json['result'] = "Time is too noon, try another room or day";
			elseif ($sRow[2] == 0)
				$json['result'] = "Endorsment already exist";
			elseif ($sRow[3] == 0)
				$json['result'] = "Proctor is not available, try another room that uses different time.";
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