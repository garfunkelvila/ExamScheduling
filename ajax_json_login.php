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
		$pass = hash('sha384', hash('sha384', $_GET['userId']) . hash('sha384', $_GET['userPassword']));
		$stmt = null;
		$stmt = $conn->prepare("CALL `select_employee_login`(?,?);");
		$stmt->bind_param('ss', $_GET['userId'], $pass);
		$stmt->execute();
		
		$loginResult = $stmt->get_result();
		$loginRow = $loginResult->fetch_row();
		if ($loginResult->num_rows == 0){
			$stmt = null;
			$stmt = $conn->prepare("CALL `update_login_attemp_counter`(?,?)");
			$stmt->bind_param('ss', $cIP,$_SERVER['HTTP_USER_AGENT']);
			$stmt->execute();

			$json['sucess'] = false;
			$json['result'] = "Password not matched";
			echo json_encode($json);
		}
		else{
			$stmt = null;
			$stmt = $conn->prepare("CALL `reset_login_attemp_counter`(?,?)");
			$stmt->bind_param('ss', $cIP,$_SERVER['HTTP_USER_AGENT']);
			$stmt->execute();

			$_SESSION["ID"] = $loginRow[0];
			$json['sucess'] = true;
			$json['result'] = $loginRow[1];
			echo json_encode($json);
		}
	}
	else{
		$json['sucess'] = false;
		$json['result'] = "Too much attemps, please try again later";
		echo json_encode($json);
	}

?>