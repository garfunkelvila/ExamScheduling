<?php
	include("util_dbHandler.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();

	#CHECK IF IP IS NOT BLOCKED
	#--------------------------
	$stmt = null;
	$stmt = $conn->prepare("CALL `check_login_attemps`(?,?)");
	$stmt->bind_param('ss', $cIP, $_SERVER['HTTP_USER_AGENT']);
	$stmt->execute();
	$lResult = $stmt->get_result();
	$lRow = $lResult->fetch_row();
	$ShowLogin = $lRow[0];

	if ($ShowLogin == "True"){
		#Check if ID exists
		#------------------
		$stmt = null;
		$stmt = $conn->prepare("SELECT COUNT(`Id Number`) FROM `users` WHERE `Id Number` = ? AND `Id Number` LIKE ?");
		$stmt->bind_param('ss', $_GET['userId'], $_GET['userId']);
		$stmt->execute();
		$countResult = $stmt->get_result();
		$countRow = $countResult->fetch_row();
		if ($countRow[0] == 0){
			$stmt = null;
			$stmt = $conn->prepare("CALL `update_login_attemp_counter`(?,?)");
			$stmt->bind_param('ss', $cIP,$_SERVER['HTTP_USER_AGENT']);
			$stmt->execute();
#
			$json['sucess'] = false;
			$json['result'] = "ID number doesn't exist";
			echo json_encode($json);
		}
		else{
			$stmt = null;
			$stmt = $conn->prepare("CALL `reset_login_attemp_counter`(?,?)");
			$stmt->bind_param('ss', $cIP,$_SERVER['HTTP_USER_AGENT']);
			$stmt->execute();
#
			$json['sucess'] = true;
			$json['result'] = "Ok";
			echo json_encode($json);
		}
	}
	else{
		$json['sucess'] = false;
		$json['result'] = "Too much login attemps, please try again later";
		echo json_encode($json);
	}
	#***************************************************
	
?>