<?php
	include_once("../util_dbHandler.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	#****************************
	if ($LoggedInAccesID != '5'){
		echo "STOP!!!";
		exit;
	}

	$pass = getPassword($_REQUEST['userPassword']);
	
	$stmt = null;
	$stmt = $conn->prepare("UPDATE `users` SET `User Password` = ? WHERE `Id Number` = ? ;");
	$stmt->bind_param('ss', $pass, $_SESSION['ID']);
	$stmt->execute();

	if ($stmt->affected_rows == 1){
		$json['sucess'] = true;
		$json['result'] = "Password sucesfully changed";
		echo json_encode($json);
	}
	else{
		$json['sucess'] = false;
		$json['result'] = "Password change failed";
		echo json_encode($json);
	}
?>