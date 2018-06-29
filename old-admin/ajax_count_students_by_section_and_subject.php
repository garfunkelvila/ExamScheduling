<?php
	include "../util_dbHandler.php";
	//-----------------------------------
	$stmt = null;
	$stmt = $conn->prepare("SELECT COUNT(`class_students`.`Id`) FROM `class_students` JOIN `classes` ON `class_students`.`Class Id` = `classes`.`Id` JOIN `subjects` ON `classes`.`Subject Id` = `subjects`.`Id` WHERE `classes`.`Section Code Full` = ? AND `subjects`.`Code` = ?");
	$stmt->bind_param('ss', $_REQUEST['section'],$_REQUEST['subject']);
	$stmt->execute();
	$Result = $stmt->get_result();
	if ($Result->num_rows > 0) {
		$Row = $Result->fetch_row();
		echo $Row[0];
	}
	else{
		echo "ERROR";
	}
?>