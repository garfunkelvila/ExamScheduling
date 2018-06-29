<?php
	include("../util_dbHandler.php");
	$stmt = null;
	$stmt = $conn->prepare("CALL `delete_user`(?,?);");
	$stmt->bind_param('ss',$_SESSION["ID"], $_REQUEST['q']);
	$stmt->execute();
	if ($stmt->affected_rows == 1){
		echo "Sucesfully deleted";
	}
	else{
		echo "Delete failed";
	}
?>