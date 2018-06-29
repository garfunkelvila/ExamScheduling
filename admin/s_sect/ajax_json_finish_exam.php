<?php
	include("../../util_dbHandler.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	if($LoggedInAccesID != '1'){
		echo "STOP!!! ";
		exit;
	}

	if ($LoggedInAccesID == '1'){
		$stmt = null;
		$stmt = $conn->prepare("CALL `finishExam`;");
		#$stmt->bind_param('si',$_SESSION['ID'], $_REQUEST['q']);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			$json['sucess'] = true;
			$json['result'] = "I cant handle this query.";
			echo json_encode($json);
		}
		else{
			$json['sucess'] = false;
			$json['result'] = "This failed? how?.";
			echo json_encode($json);
		}
	}
	else{
		echo "STOP!!!";
	}

	
?>