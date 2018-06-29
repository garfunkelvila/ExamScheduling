<?php
	include("util_dbHandler.php");
	$stmt = null;
	$stmt = $conn->prepare("UPDATE `users` SET `changePassDialog` = '1' WHERE `Id Number` = ? ;");
	$stmt->bind_param('s', $_SESSION['ID']);
	$stmt->execute();
?>