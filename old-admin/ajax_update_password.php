<?php
	include_once("../util_dbHandler.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	#****************************

	$userId = (isset($_REQUEST['id']) ? $_REQUEST['id'] : $_SESSION['ID']);
	$pass = hash('sha384', hash('sha384', $userId) . hash('sha384', $_REQUEST['userPassword']));
	
	$stmt = null;
	$stmt = $conn->prepare("UPDATE `users` SET `User Password` = ? WHERE `Id Number` = ? ;");
	$stmt->bind_param('ss', $pass, $userId);
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