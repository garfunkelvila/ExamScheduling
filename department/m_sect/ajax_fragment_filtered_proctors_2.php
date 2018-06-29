<?php 
	#used in add section pfor selector
	include "../../util_dbHandler.php";
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_filtered_professors_dean`(?,?)");
	$stmt->bind_param("ss",$_SESSION["ID"], $_REQUEST["q"]);
	$stmt->execute();
	$pResult = $stmt->get_result();
	if ($pResult->num_rows > 0) {
		while ($pRow = $pResult->fetch_assoc()) {
			?><a href="#" class="w3-bar-item w3-button" onclick="chooseProctor2('<?php echo $_REQUEST["id"]; ?>','<?php echo $pRow['Id Number']; ?>','<?php echo $_REQUEST['yearLvl']; ?>')"><?php echo $pRow['fName']; ?></a><?php
		}
	}
	else{
		?><a href="#" class="w3-bar-item w3-button">No result</a><?php
	}
?>