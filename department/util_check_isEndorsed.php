<?php 
	$stmt = null;
	$stmt = $conn->prepare("SELECT `isEndorsed`,`Name`,`Acronym` FROM `departments` WHERE `Dean_Id` = ?");
	$stmt->bind_param('s',$_SESSION['ID']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$isEndorsed = $sRow[0];
	$deptName = $sRow[1];
	$deptAccr = $sRow[2];
?>