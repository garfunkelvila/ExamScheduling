<?php
	#MIGHT BE REMOVED IN THE FUTURE,
	include_once("../../util_dbHandler.php");
	include_once("../../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
#--------------------------
	if (isNotEmpty($_REQUEST['idNumber']) && isNotEmpty($_REQUEST['fName']) && isNotEmpty($_REQUEST['lName'])) {
		$password = getDefPassword($_REQUEST['idNumber']);
		$stmt = null;
		$stmt = $conn->prepare("CALL `insert_user`(?,?,?,?,?,?,?);");
		$stmt->bind_param('sssssss',$_SESSION['ID'], $_REQUEST['idNumber'], $_REQUEST['fName'], $_REQUEST['mName'], $_REQUEST['lName'], $_REQUEST['uType'], $password);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			$json['sucess'] = true;
			$json['result'] = "Registration sucessfull";
			echo json_encode($json);
		}
		else{
			$stmt = null;
			$stmt = $conn->prepare("SELECT COUNT(`Id Number`) FROM `users` WHERE `Id Number` = ?");
			$stmt->bind_param('s', $_REQUEST['idNumber']);
			$stmt->execute();
			if($stmt->get_result()->fetch_row()[0] != 0){
				#echo "Registration failed. ID number already exist.";
				$json['sucess'] = false;
				$json['result'] = "Registration failed. ID number already exist.";
				echo json_encode($json);
			}
			else{
				#echo "Registration failed.";
				$json['sucess'] = false;
				$json['result'] = "Registration failed.";
				echo json_encode($json);
			}			
		}
	}
	else{
		#echo "Registration failed. A field is empty.";
		$json['sucess'] = false;
		$json['result'] = "Registration failed. A field is empty.";
		echo json_encode($json);
	}
?>