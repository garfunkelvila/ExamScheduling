<?php 
	#NOT USED
	include "../../util_dbHandler.php";
	$stmt = null;
	$stmt = $conn->prepare("CALL `select_sections_not_endorsed`(?,?)");
	$stmt->bind_param("ss",$_SESSION["ID"],$_REQUEST["q"]);
	$stmt->execute();
	$pResult = $stmt->get_result();
	if ($pResult->num_rows > 0) {
		while ($pRow = $pResult->fetch_assoc()) {
			?><a href="#" class="w3-bar-item w3-button" onclick="chooseSection('<?php echo $pRow['sect']; ?>')"><?php echo $pRow['sect']; ?></a><?php
		}
	}
	else{
		?><a href="#" class="w3-bar-item w3-button">No result</a><?php
	}
?>