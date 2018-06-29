<?php 
	$stmt = null;
	$stmt = $conn->prepare("SELECT `Int Val` FROM `dbconfig` WHERE `Name` = 'Stage'");
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$stage = $sRow[0];
?>