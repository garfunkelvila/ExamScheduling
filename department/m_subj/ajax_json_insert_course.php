<?php
	include("../../util_dbHandler.php");
	include("../../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();

	if ($LoggedInAccesID != '5'){
		echo "STOP!!!";
		exit;
	}

	if(isNotEmpty($_REQUEST['strCourseName']) &&
	   isNotEmpty($_REQUEST['strAcronym']) &&
	   isNotEmpty($_REQUEST['chrCode']) &&
	   strlen($_REQUEST['chrCode']) == 1 &&
	   ctype_alpha($_REQUEST['chrCode'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `insert_course`(?,?,?,?);");
		$chrCodeUpper = strtoupper($_REQUEST['chrCode']);
		$stmt->bind_param('ssss',$_SESSION["ID"], $_REQUEST['strCourseName'], $_REQUEST['strAcronym'], $chrCodeUpper);
		$stmt->execute();
		$sResult = $stmt->get_result();
		$sRow = $sResult->fetch_row();
		$isOk = $sRow[0];
		$isCourseOk = $sRow[1];

		if ($isOk == 1){
			#echo "Department sucesfully added.";
			$json['sucess'] = true;
			$json['result'] = "Course sucesfully added.";
			echo json_encode($json);
		}
		else{
			if($isCourseOk == 0){
				$json['result'] = "Existing course code.";
				echo json_encode($json);
			}
			else{
				$json['result'] = "Nothing added";
				echo json_encode($json);
			}
		}
	}
	else{
		$json['result'] = "Adding failed. Empty or invalid field.";
		echo json_encode($json);
	}
?>