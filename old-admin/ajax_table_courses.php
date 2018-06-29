<?php
	include "../util_dbHandler.php";
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	#***************************************************
	$currentDepartment = "";
	$q = str_replace(' ', '%', $_REQUEST['q']);
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_courses`(?)");
	$stmt->bind_param('s', $q);
	$stmt->execute();
	$courseResult = $stmt->get_result();
	if ($courseResult->num_rows > 0) {
		while ($courseRow = $courseResult->fetch_assoc()) {
			/*if ($currentDepartment != $courseRow["Department Id"]){
				#IF DIFFERENT: SHOW HEADER
				$currentDepartment = $courseRow["Department Id"];
				?><div class="w3-cell-row">
					<div class="my-cell"><b><?php echo $courseRow["Department Name"]; ?></b></div>
				</div><?php
				include "ajax_table_course_item.php";
			}
			else{
				#IF SAME: SKIP HEADER
				include "ajax_table_course_item.php";
			}*/
			$resultArray[] = $courseRow;
		}
		$json['sucess'] = true;
		$json['result'] = $resultArray;
		echo json_encode($json);
	}
	else{
		#resulted nothing
		$json['sucess'] = false;
		echo json_encode($json);
	}
?>