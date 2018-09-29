<?php
	include_once("../util_dbHandler.php");
	include_once("../util_validations.php");

	if(isNotEmpty($_REQUEST['deptName']) && isNotEmpty($_REQUEST['deptAccr'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `update_department`(?,?,?,?);");
		$stmt->bind_param('siss',$_SESSION["ID"], $_REQUEST['id'], $_REQUEST['deptName'], $_REQUEST['deptAccr']);
		$stmt->execute();
		if ($stmt->affected_rows == 1){
			#echo "Department sucesfully edited.";
			$json['sucess'] = true;
			$json['result'] = "Sucesfully edited";
			echo json_encode($json);
		}
		else{
			$iResult = $stmt->get_result();
			$returnRow = $iResult->fetch_row();
			
			#echo "Edited nothing";
			$json['sucess'] = false;
			$json['result'] = $returnRow[0];
			echo json_encode($json);
		}
	}
	else{
		#echo "Edit failed.";
		$json['sucess'] = false;
		$json['result'] = "Edit failed.";
		echo json_encode($json);
	}
?>