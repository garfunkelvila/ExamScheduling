<?php 
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_random_greetings`(?)");
	$stmt->bind_param('s',$_SESSION['ID']);
	$stmt->execute();
	$sResult = $stmt->get_result();
	$sRow = $sResult->fetch_row();
	$greeting = $sRow[0];
?>