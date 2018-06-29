<?php
	$url = $_SERVER['REQUEST_URI'];

	$stmt = null;
	$stmt = $conn->prepare("CALL `count_subjects_dean`(?);");
	$stmt->bind_param('s',$_SESSION['ID']);
	$stmt->execute();
	$subjCount = $stmt->get_result()->fetch_row()[0];

	$stmt = null;
	$stmt = $conn->prepare("SELECT COUNT(`ProctorId`) FROM `proctor_department` WHERE `DeanId` =?;");
	$stmt->bind_param('s',$_SESSION['ID']);
	$stmt->execute();
	$profCount = $stmt->get_result()->fetch_row()[0];

	$stmt = null;
	$stmt = $conn->prepare("CALL `count_subjects_dean`(?)");
	$stmt->bind_param('s',$_SESSION['ID']);
	$stmt->execute();
	$sectCount = $stmt->get_result()->fetch_row()[0];

	if ((strpos($url, 'manage_subjects.php') === false) && $subjCount == '0'){
		?><p class="w3-card w3-yellow w3-padding"><em>There are no subjects yet. Please start adding them by clicking <b><a href='manage_subjects.php'>here</a></b>.</em></p><?php
	}
	if ((strpos($url, 'manage_professors.php') === false) && $profCount == '0'){
		?><p class="w3-card w3-yellow w3-padding"><em>There are no professors yet. Please start adding them by clicking <b><a href='manage_professors.php'>here</a></b>.</em></p><?php
	}
	if ((strpos($url, 'manage_sections.php') === false) && $sectCount == '0'){
		?><p class="w3-card w3-yellow w3-padding"><em>There are no sections yet. Please start adding them by clicking <b><a href='manage_sections.php'>here</a></b>.</em></p><?php
	}
?>