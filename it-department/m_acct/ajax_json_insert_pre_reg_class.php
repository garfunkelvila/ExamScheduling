<?php
	include "../../util_dbHandler.php";
	if ($LoggedInAccesID != '6'){
		echo 'STOP!!!';
		exit;
	}
	$stmt = null;
	$stmt = $conn->prepare("INSERT INTO `student_class_pre_reg` (`Pre Reg Id`, `Class Id`) VALUES (?, ?);");
	$stmt->bind_param('ii', $_REQUEST['tUserId'], $_REQUEST['classId']);
	$stmt->execute();
?>