<?php
	date_default_timezone_set("Asia/Manila");

	$HTTP_CLIENT_IP = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : "";
	$HTTP_X_FORWARDED_FOR = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : "";
	$HTTP_X_FORWARDED = isset($_SERVER['HTTP_X_FORWARDED']) ? $_SERVER['HTTP_X_FORWARDED'] : "";
	$HTTP_FORWARDED_FOR = isset($_SERVER['HTTP_FORWARDED_FOR']) ? $_SERVER['HTTP_FORWARDED_FOR'] : "";
	$HTTP_FORWARDED = isset($_SERVER['HTTP_FORWARDED']) ? $_SERVER['HTTP_FORWARDED'] : "";
	$REMOTE_ADDR = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "";

	$cIP = $REMOTE_ADDR; #USED ON LOGIN ATTEMPS


	if (session_status() == PHP_SESSION_NONE){
		session_start();
	}
	$conn = new mysqli("localhost", "root", "", "db_Thesis");
	if ($conn->connect_error){
		die("Connection failed: " . mysqli_connect_error());
	}
	if(isset($_SESSION['ID'])){
		$stmt = null;
		$stmt = $conn->prepare("SELECT `users`.`First Name`, `users`.`Family Name`, `users`.`Access Id`, `users_access_types`.`Name` FROM `users` JOIN `users_access_types` ON `users`.`Access Id` = `users_access_types`.`Id` WHERE `Id Number` = ?");
		$stmt->bind_param('s', $_SESSION['ID']);
		$stmt->execute();
		$sResult = $stmt->get_result();
		$sRow = $sResult->fetch_row();
		$LoggedInName = $sRow[0] . " " . $sRow[1];
		$LoggedInAccesID = $sRow[2];
		$LoggedInAccesName = $sRow[3];
	}
	else{
		$LoggedInName = 'n/a';
		$LoggedInAccesID = 'n/a';
	}
	$stmt = null;
	$stmt = $conn->prepare("CALL `insert_logs_page_visit`(?,?,?,?,?,?,?,?);");
	$stmt->bind_param('ssssssss', $HTTP_CLIENT_IP, $HTTP_X_FORWARDED_FOR, $HTTP_X_FORWARDED, $HTTP_FORWARDED_FOR, $HTTP_FORWARDED, $REMOTE_ADDR, $_SERVER['REQUEST_URI'],  $_SERVER['HTTP_USER_AGENT']);
	$stmt->execute();
	include 'util_passCalc.php';
?>