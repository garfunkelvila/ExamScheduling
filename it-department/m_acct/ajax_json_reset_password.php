<?php
	include_once("../../util_dbHandler.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if ($LoggedInAccesID != '6'){
		echo 'STOP!!!';
		exit;
	}
	#****************************
	#$userId = (isset($_REQUEST['id']) ? $_REQUEST['id'] : $_SESSION['ID']);
	$pass = getDefPassword($_REQUEST['id']);
	
	$stmt = null;
	$stmt = $conn->prepare("UPDATE `users` SET `User Password` = ? WHERE `Id Number` = ? ;");
	$stmt->bind_param('ss', $pass, $_REQUEST['id']);
	$stmt->execute();

	if ($stmt->affected_rows == 1){
		$json['sucess'] = true;
		$json['result'] = "Password sucesfully reset";
		echo json_encode($json);
	}
	else{
		$json['sucess'] = false;
		$json['result'] = "Password reset failed\nUser may still have the default password";
		echo json_encode($json);
	}
?>