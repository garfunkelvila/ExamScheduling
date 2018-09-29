<?php
	include_once("../../../util_dbHandler.php");
	include_once("../../../util_validations.php");
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


	if(isNotEmpty($_REQUEST['skedId']) && isNotEmpty($_REQUEST['dayId']) && isNotEmpty($_REQUEST['room'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `update_exam_schedule_merge`(?,?,?,?);");
		$stmt->bind_param('iiss',$_REQUEST['skedId'], $_REQUEST['dayId'], $_REQUEST['room'], $formattedTime);
		$stmt->execute();
		$sResult = $stmt->get_result();
		$sRow = $sResult->fetch_row();
		#$sRow[0]

		if ($sRow[0] == 1){
			$json['sucess'] = true;
			$json['result'] = "Schedule sucesfully merged.";
			echo json_encode($json);
		}
		else{
			if ($sRow[1] == 0)
				$json['result'] = "Err: HasTimeMatch failed.";
			elseif ($sRow[2] == 0)
				$json['result'] = "Proctor is not available.";
			else
				$json['result'] = "Ooop Something went wrong.";
			echo json_encode($json);
		}
	}
	else{
		$json['result'] = "Adding failed. Empty or invalid field.";
		echo json_encode($json);
	}
?>