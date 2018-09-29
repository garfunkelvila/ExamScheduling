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
	$endTime = date("H:i:s", strtotime($_REQUEST['endTime']));


	$stmt = null;
	$stmt = $conn->prepare("CALL `check_exam_schedule_mergable`(?,?,?,?,?,?,?);");
	$stmt->bind_param('ssissss', $_REQUEST['subjectCode'], $_REQUEST['sectionCodeFull'], $_REQUEST['dayId'], $startTime, $endTime, $_REQUEST['room'], $_REQUEST['proctorId']);
	$stmt->execute();

	$mResult = $stmt->get_result();
	if ($iResult->num_rows > 0) {
		$returnRow = $iResult->fetch_row();

		$SubjectsHitCount =  $returnRow[0];
		$SectionsHitCount = $returnRow[1];
		$SubjectsHit = $returnRow[2];
		$SectionsHit =  $returnRow[3];

		if ($SubjectsHitCount > 0 || $SectionsHitCount > 0){
			#Have time, room & proctor match? Yes
			if(isset($_REQUEST['merge']) && $_REQUEST['merge'] == 'true'){

			}
		}
		else{
			
		}

		
	}




	if(isNotEmpty($_REQUEST['subjectCode'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `insert_exam_schedule`(?,?,?,?,?,?,?,?, FALSE);");
		$stmt->bind_param('sssissss',$_SESSION['ID'], $_REQUEST['subjectCode'], $_REQUEST['sectionCodeFull'], $_REQUEST['dayId'], $startTime, $endTime, $_REQUEST['room'], $_REQUEST['proctorId']);
		$stmt->execute();

		$iResult = $stmt->get_result();

		if ($iResult->num_rows > 0) {

			$returnRow = $iResult->fetch_row();
			#print_r($iResult);
			$sucess =  $returnRow[0];
			$classValid = $returnRow[1];
			$timeDiff = $returnRow[2];
			$startDiff =  $returnRow[3];
			$roomHit = $returnRow[4];
			$procHit =  $returnRow[5];
			$classHit = $returnRow[6];
			$validProf = $returnRow[7];
			
			#***********
			if ($sucess == true){
				$json['sucess'] = True;
				$json['result'] = "Sucesfully Added";
				echo json_encode($json);
			}
			elseif ($classValid == 0){
				$json['sucess'] = false;
				$json['result'] = "Subject doesn't exist in the section.";
				echo json_encode($json);
			}
			elseif($timeDiff < 60){
				$json['sucess'] = false;
				$json['result'] = "Too short exam time.";
				echo json_encode($json);
			}
			elseif($timeDiff > 60){
				$json['sucess'] = false;
				$json['result'] = "Too long exam time.";
				echo json_encode($json);
			}
			elseif($startDiff < 0 ){
				$json['sucess'] = false;
				$json['result'] = "Too early exam time.";
				echo json_encode($json);
			}
			elseif($startDiff > 600){
				$json['sucess'] = false;
				$json['result'] = "Too late exam time.";
				echo json_encode($json);
			}
			elseif($roomHit > 0){
				$json['sucess'] = false;
				$json['result'] = "The room is not available at choosen time.";
				echo json_encode($json);
			}
			elseif($procHit > 0){
				$json['sucess'] = false;
				$json['result'] = "Proctor is not available at choosen time.";
				echo json_encode($json);
			}
			elseif($classHit > 0){
				$json['sucess'] = false;
				$json['result'] = "Class already scheduled";
				echo json_encode($json);
			}
			elseif($validProf <= 0){
				$json['sucess'] = false;
				$json['result'] = "Id number is not a valid";
				echo json_encode($json);
			}
			else{
				#echo "Adding failed.";
				$json['sucess'] = false;
				$json['result'] = "Nothing Added.";
				echo json_encode($json);
			}
		}
		else{
			#resulted nothing
			$json['sucess'] = false;
			$json['result'] = "FATAL ERROR";
			echo json_encode($json);
		}
	}
	else{
		#echo "Adding failed.";
		$json['sucess'] = false;
		$json['result'] = "Adding failed. Empty or invalid field.";
		echo json_encode($json);
	}
?>