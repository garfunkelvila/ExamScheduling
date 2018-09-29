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
	#**********************
	$stmt = null;
	$stmt = $conn->prepare("CALL `delete_course`(?,?);");
	$stmt->bind_param('ss',$_SESSION["ID"], $_REQUEST['code']);
	$stmt->execute();
	if ($stmt->affected_rows == 1){
		#echo "Department sucesfully added.";
		$json['sucess'] = true;
		$json['result'] = "Course sucesfully deleted.";
		echo json_encode($json);
	}
	else{
		$json['result'] = "Delete failed.";
		echo json_encode($json);
	}
?>