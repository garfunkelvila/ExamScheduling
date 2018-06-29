<?php
	include("../../util_dbHandler.php");
	$stmt = null;
	if ($_REQUEST['year'] == "-"){
		$stmt = $conn->prepare("SELECT `subjects`.`Id`, `subjects`.`Name` FROM `subjects` WHERE `Course Code` = ?;");
		$stmt->bind_param('s',$_REQUEST['course']);
	}
	else{
		$stmt = $conn->prepare("SELECT `subjects`.`Id`, `subjects`.`Name` FROM `subjects` WHERE `Course Code` = ? AND `Year Level` = ?;");
		$stmt->bind_param('si',$_REQUEST['course'], $_REQUEST['year']);
	}

	$stmt->execute();
	$departments = $stmt->get_result();
	if ($departments->num_rows > 0) {
		while ($deptRow = $departments->fetch_assoc()) {
			?><option value="<?php echo $deptRow['Id'] ?>"><?php echo $deptRow['Name'] ?></option><?php
		}
	}
	else{
		?><option value="-">No subject to show</option><?php
	}
?>