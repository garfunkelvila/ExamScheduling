<?php
	include_once("../util_dbHandler.php");
	include_once("../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	#***************************************************
	if(isNotEmpty($_REQUEST['deptName']) && isNotEmpty($_REQUEST['deptAccr'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `insert_departments`(?,?,?);");
		$stmt->bind_param('sss',$_SESSION["ID"], $_REQUEST['deptName'], $_REQUEST['deptAccr']);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			#echo "Department sucesfully added.";
			$json['sucess'] = true;
			$json['result'] = "Department sucesfully added.";
			echo json_encode($json);
		}
		else{
			$iResult = $stmt->get_result();
			$returnRow = $iResult->fetch_row();

			#echo "Adding failed.";
			$json['sucess'] = false;
			$json['result'] = $returnRow[0];
			echo json_encode($json);
		}
	}
	else{
		#echo "Adding failed.";
		$json['sucess'] = false;
			$json['result'] = "Adding failed. Empty or invalid field.";
			echo json_encode($json);
	}
?>