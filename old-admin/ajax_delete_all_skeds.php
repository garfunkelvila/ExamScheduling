<?php
	include_once("../util_dbHandler.php");
	include_once("../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	#**********************

	$stmt = null;
	$stmt = $conn->prepare("CALL delete_all_exam_schedules(?);");
	$stmt->bind_param('s',$_SESSION["ID"]);
	$stmt->execute();
	if ($stmt->affected_rows == 1){
		#echo "Course sucesfully edited.";
		$json['sucess'] = true;
		$json['result'] = "Sucesfully edited";
		echo json_encode($json);
	}
	else{
		#echo "Edited nothing";
		$json['sucess'] = false;
		$json['result'] = "Edited nothing";
		echo json_encode($json);
	}
	
?>