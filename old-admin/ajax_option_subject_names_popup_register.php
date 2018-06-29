<?php
	include "../util_dbHandler.php";


	if ($_REQUEST['level'] != 0){
		$stmt = null;
		$stmt = $conn->prepare("CALL `select_subjects_pre_register`(?,?,?)");
		$stmt->bind_param('sii', $_REQUEST['course'], $_REQUEST['level'], $_REQUEST['tUserId']);
		$stmt->execute();
		$courseResult = $stmt->get_result();
		if ($courseResult->num_rows > 0) {
			?><option value="0">Select a subject</option><?php
			while ($subjRow = $courseResult->fetch_assoc()) {
				?><option value="<?php echo $subjRow['Id']; ?>"><?php echo $subjRow['Name']; ?></option><?php
			}
		}
		else{
			?><option value="0">No subject available</option><?php
		}
	}
	else{
		?><option value="0">Select a year level first</option><?php
	}
?>