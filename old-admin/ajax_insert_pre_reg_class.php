<?php
	include "../util_dbHandler.php";

	$stmt = null;
	$stmt = $conn->prepare("INSERT INTO `db_main`.`student_class_pre_reg` (`Pre Reg Id`, `Class Id`) VALUES (?, ?);");
	$stmt->bind_param('ii', $_REQUEST['tUserId'], $_REQUEST['classId']);
	$stmt->execute();
?>