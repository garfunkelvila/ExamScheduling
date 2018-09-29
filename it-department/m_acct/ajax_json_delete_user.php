<?php
	include_once("../../util_dbHandler.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	if ($LoggedInAccesID != '6'){
		echo 'STOP!!!';
		exit;
	}

	$stmt = null;
	$stmt = $conn->prepare("CALL `delete_user`(?,?);");
	$stmt->bind_param('ss',$_SESSION["ID"], $_REQUEST['q']);
	$stmt->execute();
	if ($stmt->affected_rows == 1){
		$json['sucess'] = true;
		$json['result'] = 'Sucesfully deleted.';
		echo json_encode($json);
	}
	else{
		$json['sucess'] = true;
		$json['result'] = 'Delete failed.';
		echo json_encode($json);
	}
?>