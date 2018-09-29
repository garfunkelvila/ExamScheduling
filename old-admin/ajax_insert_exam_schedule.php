<?php
	include_once("../util_dbHandler.php");
	include_once("../util_validations.php");
	$json = array(
		'sucess' => false,
		'result' => 0
	);
	$resultArray = array();
	#***************************************************

	$startTime = date("H:i:s", strtotime($_REQUEST['startTime']));
	#-------
	#$tmpTime = new DateTime($_REQUEST['startTime']);
	#$tmpTime->add(new DateInterval("PT" . $_REQUEST['examLength'] . "M"));
	#echo $tmpTime->format('Y-m-d') . "\n";
	#$endTime = date("H:i:s", strtotime($_REQUEST['endTime']));
	#$endTime = $tmpTime->format("H:i:s");


	$stmt = null;
	$stmt = $conn->prepare("CALL `check_exam_schedule_mergable`(?,?,?,?,?,?,?);");
	$stmt->bind_param('ssisiss', $_REQUEST['subjectCode'], $_REQUEST['sectionCodeFull'], $_REQUEST['dayId'], $startTime, $_REQUEST['examLength'], $_REQUEST['room'], $_REQUEST['proctorId']);
	$stmt->execute();



	$mResult = $stmt->get_result();

	if ($mResult->num_rows > 0) {
		$returnRow = $mResult->fetch_row();



		$SubjectsHitCount =  $returnRow[0];
		$SectionsHitCount = $returnRow[1];
		$SubjectsHit = $returnRow[2];
		$SectionsHit =  $returnRow[3];

		if ($SubjectsHitCount > 0 || $SectionsHitCount > 0){
			#Have time, room & proctor match? Yes
			if(isset($_REQUEST['merge']) && $_REQUEST['merge'] == 'true'){
				$bypass = '1';	#it is used by the insert
				include_once("ajax_insert_exam_schedule_insert_routine.php");
			}
			else{
				$json['sucess'] = False;
				$json['result'] = "Merge with " . $SubjectsHit . " - " . $SectionsHit . "?";
				echo json_encode($json);
			}
		}
		else{
			#Have time, room & proctor match? No
			$bypass = '0';	#it is used by the insert
			include_once("ajax_insert_exam_schedule_insert_routine.php");
		}
	}
?>