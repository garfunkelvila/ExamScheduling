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
	if(isNotEmpty($_REQUEST['name']) && isNotEmpty($_REQUEST['acronym'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `update_course`(?,?,?,?);");
		$stmt->bind_param('ssss',$_SESSION["ID"], $_REQUEST['name'], $_REQUEST['acronym'], $_REQUEST['code']);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			#echo "Course sucesfully edited.";
			$json['sucess'] = true;
			$json['result'] = "Sucesfully edited";
			echo json_encode($json);
		}
		else{
			$iResult = $stmt->get_result();
			$returnRow = $iResult->fetch_row();
			
			#echo "Edited nothing";
			$json['sucess'] = false;
			$json['result'] = $returnRow[0];
			echo json_encode($json);
		}
	}
	else{
		#echo "Edit failed.";
		$json['sucess'] = false;
		$json['result'] = "Edit failed.";
		echo json_encode($json);
	}
?>