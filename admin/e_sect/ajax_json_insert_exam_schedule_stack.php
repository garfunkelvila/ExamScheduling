<?php
	include_once("../../util_dbHandler.php");
	include_once("../../util_validations.php");
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
		//THIS DONT WORK DUE TO MULTIPLE QUERIES
		//$stmt = $conn->prepare("CALL `insert_exam_schedule_stack`(?,?,?);");
		//$stmt->bind_param('iis', $_REQUEST['endorseId'], $_REQUEST['dayId'], $_REQUEST['room']);
		//$stmt->execute();
		//$sResult = $stmt->get_result();
		//$sRow = $stmt->fetch_row();
		//FIX BUT Needs to sanitize
		$conn->multi_query("CALL `insert_exam_schedule_stack`(" . $_REQUEST['endorseId'] . ", " . $_REQUEST['dayId'] . ", '" . $_REQUEST['room'] . "');");
		$conn->next_result();
		$sResult = $conn->store_result();
		$sRow = $sResult->fetch_row();
		$sResult->free();
		
		//do {
		// FROM PHP MANUAL MULTI_QUERY
		//	/* store first result set */
		//	if ($sResult = $conn->store_result()) {
		//		$sRow = $sResult->fetch_row()
//		//		$sResult->free();
		//	}
		//	/* print divider */
		//	/*if ($mysqli->more_results()) {
		//		printf("-----------------\n");
		//	}*/
		//} while ($conn->next_result());

		if ($sRow[0] == 1){
			$json['sucess'] = true;
			$json['result'] = "Schedule sucesfully added." . $_REQUEST['endorseId'] . ":" . $_REQUEST['dayId'] . ":" . $_REQUEST['room'];
			echo json_encode($json);
		}
		else{
			$json['result'] = "Nothing added.";
			if ($sRow[1] == 0)
				$json['result'] = "Time is too noon, try another room or day";
			if ($sRow[2] == 0)
				$json['result'] = "Endorsment already exist";
			if ($sRow[3] == 0)
				$json['result'] = "Proctor is not available, try another room that uses different time." . $sRow[0] . $sRow[1] . $sRow[3] . $sRow[3];
			echo json_encode($json);
		}
	}
	else{
		$json['result'] = "Adding failed. Empty or invalid field.";
		echo json_encode($json);
	}
?>