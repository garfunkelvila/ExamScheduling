<?php
	include_once "../../util_dbHandler.php";
	if ($LoggedInAccesID != '6'){
		echo 'STOP!!!';
		exit;
	}
	unlink('backup/' . $_REQUEST['name']);
	echo "Done";
?>