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
	//*********************
	if(isNotEmpty($_REQUEST['subjName']) && isNotEmpty($_REQUEST['subjCode']) && isNotEmpty($_REQUEST['subjMajr'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `update_subject`(?,?,?,?,?);");
		$stmt->bind_param('sissi',$_SESSION['ID'], $_REQUEST['q'], $_REQUEST['subjName'], $_REQUEST['subjCode'], $_REQUEST['subjMajr']);
		$stmt->execute();

		$sResult = $stmt->get_result();
		$sRow = $sResult->fetch_row();
		$isOk = $sRow[1]; #this index returns boolean


		if ($isOk){
			$json['sucess'] = true;
			$json['result'] = "Sucesfully edited";
			echo json_encode($json);
		}
		else{
			$json['sucess'] = false;
			$json['result'] = "Edit failed";
			echo json_encode($json);
		}
	}
	else{
		#echo "Adding failed.";
		$json['sucess'] = false;
		$json['result'] = "Edit failed. Empty or invalid field.";
		echo json_encode($json);
	}
?>