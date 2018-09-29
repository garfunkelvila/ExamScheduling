<?php
	include_once("../util_dbHandler.php");
	include_once("../util_validations.php");


	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();

	if (isNotEmpty($_REQUEST['fName']) && isNotEmpty($_REQUEST['lName'])) {
		$stmt = null;
		$stmt = $conn->prepare("CALL `update_user`(?,?,?,?,?);");
		#Currently this wont check for duplicate
		$stmt->bind_param('sssss',$_SESSION["ID"], $_REQUEST['idNumber'], $_REQUEST['fName'],$_REQUEST['mName'],$_REQUEST['lName']);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			$json['sucess'] = true;
			$json['result'] = 'Sucesfully updated.';
			echo json_encode($json);
		}
		else{
			#echo "Update failed. Unhandled exemption occured. Please tell the programmer :" . $stmt->error;
			$json['sucess'] = false;
			$json['result'] = 'Edited nothing.';
			echo json_encode($json);
		}
	}
	else{
		echo "Update failed.";
		$json['sucess'] = false;
		$json['result'] = 'Update failed.';
		echo json_encode($json);
	}
?>