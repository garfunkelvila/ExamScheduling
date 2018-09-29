<?php
	include_once "../../util_dbHandler.php";
	if ($LoggedInAccesID != '6'){
		echo 'STOP!!!';
		exit;
	}
	$stmt = null;
	$conn->multi_query(file_get_contents('backup/' . $_REQUEST['name']));
	echo "Done";
?>