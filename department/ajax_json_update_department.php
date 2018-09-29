<?php
	include_once("../util_dbHandler.php");
	include_once("../util_validations.php");

	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if ($LoggedInAccesID != '5'){
		echo "STOP!!!";
		exit;
	}
	//*********************
	if(isNotEmpty($_REQUEST['deptName']) && isNotEmpty($_REQUEST['deptAccr'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `update_department`(?,?,?);");
		$stmt->bind_param('sss',$_SESSION['ID'], $_REQUEST['deptName'], $_REQUEST['deptAccr']);
		$stmt->execute();

		$sResult = $stmt->get_result();
		$sRow = $sResult->fetch_row();
		$isOk = $sRow[1]; #this index returns boolean

		if ($isOk){
			$json['sucess'] = true;
			$json['result'] = "Sucesfully renamed";
			echo json_encode($json);
		}
		else{
			$json['sucess'] = false;
			$json['result'] = "Rename failed";
			echo json_encode($json);
		}
	}
	else{
		#echo "Adding failed.";
		$json['sucess'] = false;
		$json['result'] = "Rename failed. Empty or invalid field.";
		echo json_encode($json);
	}
?>