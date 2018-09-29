<?php
	include_once "../util_dbHandler.php";

	#***************************************************
	if ($_REQUEST['dept'] != 0){
		$stmt = null;
		$stmt = $conn->prepare("SELECT * FROM `courses` WHERE `Department Id` = ? ORDER BY `Name` ASC;");
		$stmt->bind_param('i',$_REQUEST['dept']);
		$stmt->execute();
		$courseResult = $stmt->get_result();
		if ($courseResult->num_rows > 0) {
			?><option value="0">Select a course</option><?php
			while ($courseRow = $courseResult->fetch_assoc()) {
				?><option value="<?php echo $courseRow['Course Code']; ?>"><?php echo $courseRow['Name']; ?></option><?php
			}
		}
		else{
			?><option value="0">No course available</option><?php
		}
	}
	else{
		?><option value="0">Select a department first</option><?php
	}
?>