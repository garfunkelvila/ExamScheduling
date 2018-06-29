<?php
	include("../util_dbHandler.php");
	include("../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	#**********************
	$stmt = null;
	$stmt = $conn->prepare("CALL `delete_student_from_class`(?);");
	$stmt->bind_param('i', $_REQUEST['userId']);
	if (isset($_SESSION["ID"])){
		$stmt->execute();
	}

	if ($stmt->affected_rows == 1){
		#echo "Department sucesfully added.";
		$json['sucess'] = true;
		$json['result'] = "Student removed from class sucesfully.";
		echo json_encode($json);
	}
	else{
		$json['result'] = "Remove failed.";
		echo json_encode($json);
	}
?>