<?php
	include("../util_dbHandler.php");
	include("../util_validations.php");

	#setcookie("deptName", "", time()-3600);
	#setcookie("deptAccr", "", time()-3600);

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
		$stmt = $conn->prepare("CALL `insert_department`(?,?,?);");
		$stmt->bind_param('sss',$_SESSION['ID'], $_REQUEST['deptName'], $_REQUEST['deptAccr']);
		$stmt->execute();

		$sResult = $stmt->get_result();
		$sRow = $sResult->fetch_row();
		$isOk = $sRow[0]; #this index returns boolean

		if ($isOk){
			$json['sucess'] = true;
			$json['result'] = "Sucesfully entered";
			echo json_encode($json);
		}
		else{
			if ($sRow[1] == 0){
				$json['result'] = "Name already exist.";
			}
			elseif ($sRow[2] == 0){
				$json['result'] = "Accronym already exist.";
			}
			elseif ($sRow[3] == 0){
				$json['result'] = "You already have a department";
			}
			else{
				$json['result'] = "Enter Failed";
			}
			$json['sucess'] = false;
			echo json_encode($json);
		}
	}
	else{
		#echo "Adding failed.";
		$json['sucess'] = false;
		$json['result'] = "Enter failed. Empty or invalid field.";
		echo json_encode($json);
	}
	
?>