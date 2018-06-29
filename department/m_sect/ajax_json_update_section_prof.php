<?php
	include("../../util_dbHandler.php");
	include("../../util_validations.php");
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
	if(isNotEmpty($_REQUEST['profId'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `update_class_professor`(?,?,?);");
		$stmt->bind_param('ssi',$_SESSION['ID'], $_REQUEST['profId'], $_REQUEST['cId']);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			#echo "Course sucesfully edited.";
			$json['sucess'] = true;
			$json['result'] = "Sucesfully edited";
			echo json_encode($json);
		}
		else{
			#$iResult = $stmt->get_result();
			#$returnRow = $iResult->fetch_row();
			
			#echo "Edited nothing";
			$json['sucess'] = false;
			$json['result'] = "Change failed.";
			echo json_encode($json);
		}
	}
	else{
		#echo "Edit failed.";
		$json['sucess'] = false;
		$json['result'] = "Change failed.";
		echo json_encode($json);
	}
?>