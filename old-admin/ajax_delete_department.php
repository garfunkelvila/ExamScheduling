<?php
	include("../util_dbHandler.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	#**********************
	$stmt = null;
	$stmt = $conn->prepare("CALL `delete_department`(?,?);");
	$stmt->bind_param('si',$_SESSION["ID"], $_REQUEST['q']);
	$stmt->execute();
	if ($stmt->affected_rows == 1){
		#echo "Sucesfully deleted";
		$json['sucess'] = true;
		$json['result'] = "Sucesfully deleted";
		echo json_encode($json);
	}
	else{
		#echo "Delete failed";
		$json['sucess'] = true;
		$json['result'] = "Delete failed";
		echo json_encode($json);
	}
?>