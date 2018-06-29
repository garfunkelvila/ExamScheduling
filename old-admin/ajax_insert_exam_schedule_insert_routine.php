<?php
	if(isNotEmpty($_REQUEST['subjectCode'])){
		$stmt = null;
		$stmt = $conn->prepare("CALL `insert_exam_schedule`(?,?,?,?,?,?,?,?,?);");
		$stmt->bind_param('sssisisss',$_SESSION['ID'], $_REQUEST['subjectCode'], $_REQUEST['sectionCodeFull'], $_REQUEST['dayId'], $startTime, $_REQUEST['examLength'], $_REQUEST['room'], $_REQUEST['proctorId'], $bypass);
		$stmt->execute();

		$iResult = $stmt->get_result();
		#print_r($iResult);


		if ($iResult->num_rows > 0) {

			$returnRow = $iResult->fetch_row();
			#print_r($returnRow);
			#echo json_encode($returnRow);

			
			$sucess =  $returnRow[0];
			$classValid = $returnRow[1];
			#$timeDiff = $returnRow[2];
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
			#elseif($timeDiff < 60){
			#	$json['sucess'] = false;
			#	$json['result'] = "Too short exam time.";
			#	echo json_encode($json);
			#}
			#elseif($timeDiff > 60){
			#	$json['sucess'] = false;
			#	$json['result'] = "Too long exam time.";
			#	echo json_encode($json);
			#}
			elseif($startDiff < 0 ){
				$json['sucess'] = false;
				$json['result'] = "Too early exam time.";
				echo json_encode($json);
			}
			elseif($startDiff > 360){
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